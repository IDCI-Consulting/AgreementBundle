<?php

namespace IDCI\Bundle\AgreementBundle\Form\Type;

use IDCI\Bundle\AgreementBundle\Handler\AgreementHandlerInterface;
use IDCI\Bundle\AgreementBundle\Model\Term;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type as Type;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgreementType extends AbstractType
{
    private $agreementHandler;

    public function __construct(AgreementHandlerInterface $agreementHandler)
    {
        $this->agreementHandler = $agreementHandler;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired([
                'term_reference',
            ])
            ->setDefaults([
                'term' => null,
                'label_format' => '%s',
            ])
            ->setAllowedTypes('term_reference', ['string'])
            ->setNormalizer('term', function (Options $options) {
                return $this->agreementHandler->getCurrentTerm($options['term_reference']);
            })
            ->setNormalizer('label', function (Options $options) {
                return sprintf(
                    $options['label_format'],
                    sprintf('%s (v%s)', $options['term']->getDescription(), $options['term']->getVersion())
                );
            })
            ->setNormalizer('label_attr', function (Options $options, $value) {
                return array_merge($value, [
                    'data-uri' => $options['term']->getUri(),
                ]);
            })
        ;
    }

    public function getParent()
    {
        return Type\CheckboxType::class;
    }
}
