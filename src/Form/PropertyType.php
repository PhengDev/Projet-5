<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('type', ChoiceType::class, [
                'choices' => $this->getTYPE()
            ])
            ->add('series', ChoiceType::class, [
                'choices' => $this->getSERIES()
            ])
            ->add('color', ChoiceType::class, [
                'choices' => $this->getCOLOR()
            ])
            ->add('power')
            ->add('costEnergy', ChoiceType::class, [
                'choices' => $this->getCOSTENERGY()
            ])
            ->add('costCombo')
            ->add('powerCombo')
            ->add('personage', ChoiceType::class, [
                'choices' => $this->getPERSONAGE()
            ])
            ->add('origin', ChoiceType::class, [
                'choices' => $this->getORIGIN()
            ])
            ->add('era', ChoiceType::class, [
                'choices' => $this->getERA()
            ])
            ->add('rarity', ChoiceType::class, [
                'choices' => $this->getRARITY()
            ])
            ->add('description')
            ->add('price')
            ->add('sold')
            ->add('imageFile', FileType::class, [
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getRARITY()
    {
        $choices = Property::RARITY;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getTYPE()
    {
        $choices = Property::TYPE;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getSERIES()
    {
        $choices = Property::SERIES;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getPERSONAGE()
    {
        $choices = Property::PERSONAGE;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getCOLOR()
    {
        $choices = Property::COLOR;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getCOSTENERGY()
    {
        $choices = Property::COSTENERGY;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getERA()
    {
        $choices = Property::ERA;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getORIGIN()
    {
        $choices = Property::ORIGIN;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

}
