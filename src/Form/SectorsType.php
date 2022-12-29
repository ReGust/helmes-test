<?php

namespace App\Form;

use App\Entity\Sector;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class SectorsType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => ['pattern' => '[a-zA-Z]*']
            ])
            ->add('sectors', ChoiceType::class, [
                'choices' => $this->resolveChoices(),
                'multiple' => true,
                'attr' => ['size' => '25']
            ])
            ->add('agree_to_terms', CheckboxType::class, [
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    private function resolveChoices(): array
    {
        $repo = $this->getSectorRepository();
        // get main sectors
        $sectors = $repo->findBy(['parent' => null]);

        $sectorTree = array();
        foreach ($sectors as $sector) {
            $sectorTree[$sector->getName()] = $sector->getValue();
            $depth = 0;

            // recursivly build the category tree
            $subSectors = $this->getChildren($sector->getId(), $depth);
            $sectorTree = array_merge($sectorTree, $subSectors);
        }

        return $sectorTree;
    }

    private function getSectorRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Sector::class);
    }

    public function getChildren($parent, $depth)
    {
        // each level is one $linestart variable
        $linestart = '&nbsp;&nbsp;&nbsp;&nbsp;';
        for ($i = 0;  $i < $depth; $i++) {
            $linestart .= $linestart;
        }

        $depth++;
        $repo = $this->getSectorRepository();
        $sectors = $repo->findBy(['parent' => $parent]);

        $sectorTree = array();
        foreach ($sectors as $sector) {
            $fieldText = html_entity_decode($linestart . $sector->getName());
            $sectorTree[$fieldText] = $sector->getValue();
            $tempTree = $this->getChildren($sector->getId(), $depth);
            if (!empty($tempTree)) {
                $sectorTree = array_merge($sectorTree,$tempTree);
            }
        }

        return $sectorTree;
    }
}
