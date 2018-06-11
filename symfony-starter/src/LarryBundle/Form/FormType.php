<?php
/**
 * Created by PhpStorm.
 * User: larry
 * Date: 2018/5/25
 * Time: 9:31 PM
 */

namespace LarryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilder;

class FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("username", "Symfony\Component\Form\Extension\Core\Type\TextType",
                array("attr" => array("maxlength" => 30)))
            ->add("email","Symfony\Component\Form\Extension\Core\Type\EmailType",
                array("attr" => array("maxlength" => 50)))
            ->add("password1","Symfony\Component\Form\Extension\Core\Type\PasswordType",
                array( "attr" => array("maxlength" => 30)))
            ->add("password2","Symfony\Component\Form\Extension\Core\Type\PasswordType",
                array( "attr" => array("maxlength" => 30)))
            ->add("sex","Symfony\Component\Form\Extension\Core\Type\ChoiceType",
                array("choices" => array("male" =>"male", "female"=>"female"),"choices_as_values"=>true, "multiple"=>false))
            ->add("birthday","Symfony\Component\Form\Extension\Core\Type\BirthdayType")
            ->add("country", "Symfony\Component\Form\Extension\Core\Type\CountryType")
            ->add("blog", "Symfony\Component\Form\Extension\Core\Type\UrlType", array("required"=>false))
            ->add("income", "Symfony\Component\Form\Extension\Core\Type\MoneyType",
                array("currency"=>"CNY", "required"=>false))
            ->add("hobby","Symfony\Component\Form\Extension\Core\Type\ChoiceType",
                array("choices" => array("music"=>"music", "sports"=>"sports", "food"=>"food"),"choices_as_values"=>true, "expanded"=>true, "multiple"=>true))
            ->add("photo", "Symfony\Component\Form\Extension\Core\Type\FileType",array("required"=>false))
            ->add("note", "Symfony\Component\Form\Extension\Core\Type\TextareaType",array("required"=>false))

            ->add("Submit", "Symfony\Component\Form\Extension\Core\Type\SubmitType")
            ->add("Reset", "Symfony\Component\Form\Extension\Core\Type\ResetType")
        ;
    }

//    public function getName()
//    {
//        return "form";
//    }
//
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            "form" => Form::class,
//        ));
//    }

}
