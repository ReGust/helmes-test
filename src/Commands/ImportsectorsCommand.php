<?php
namespace App\Commands;

use App\Entity\Sector;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use DOMXPath;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ImportsectorsCommand extends Command
{
    private $em;

    const levelIdentifier = "&nbsp;&nbsp;&nbsp;&nbsp;";

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('import-sectors')
            ->setDescription('Imports sectors from index.html')
            ->addArgument('filename', InputArgument::REQUIRED, 'Enter file location');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sectorsRepo = $this->em->getRepository(Sector::class);
        $htmlFileName = $input->getArgument('filename');

        if (!file_exists($htmlFileName)) {
            throw new Exception($htmlFileName. ' not present in directory');
        }

        $html = file_get_contents($htmlFileName);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">'. $html);
        $xpath = new DOMXpath($dom);
        $nodes = $xpath->query("//option");

        $currentLevel = 0;
        $parents[0] = array('id' => null);
        $previousNodeLevel = null;
        foreach ($nodes as $key => $node) {
            $isParent = false;
            $levelCounter = substr_count(htmlentities($node->nodeValue), self::levelIdentifier);

            $nodeText = $this->trimHtmlString($node->nodeValue);
            $nodeValue = $node->getAttribute('value');

            $parentId = null;
            if ($levelCounter === 0) {
                $isParent = true;
            }
            // on the same tree level
            elseif ($levelCounter === $previousNodeLevel) {
                $parentId = $parents[$levelCounter]['id'];
            }
            // get previous level node
            elseif ($levelCounter > $previousNodeLevel) {
                $parentId = $parents[$levelCounter - 1]['id'];
                $isParent = true;
            }

            $sectorData = $this->processRow($nodeText, $parentId);

            // queries if sector with the name and parent exist
            $searchBy = ['name' => $nodeText, 'parent' => $parentId];
            $sectorExists = $sectorsRepo->findOneBy($searchBy);

            if ($sectorExists instanceof Sector) {
                $parents[$levelCounter]['id'] = $sectorExists->getId();
            } else {
                $sector = new Sector();
                $sector->setName($sectorData['name']);
                $sector->setParent($parentId);
                $sector->setValue($nodeValue);

                $this->em->persist($sector);
                $this->em->flush();

                if ($isParent) {
                    $parents[$levelCounter]['id'] = $sector->getId();
                }
            }

            $previousNodeLevel = $currentLevel;
        }

        return Command::SUCCESS;
    }

    private function processRow($nodeValue, $nodeId)
    {
        $currentLevel = substr_count(htmlentities($nodeValue), self::levelIdentifier);

        if ($currentLevel == 0) {
            $parent = null;
        } else {
            $parent = $nodeId;
        }

        $result = array(
            'name' => html_entity_decode($nodeValue),
            'id' => $parent
        );

        return $result;
    }

    private function trimHtmlString(string $string)
    {
        return str_replace("&nbsp;", "", htmlentities($string));
    }

}