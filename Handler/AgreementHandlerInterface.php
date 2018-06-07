<?php

namespace IDCI\Bundle\AgreementBundle\Handler;

use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;
use Symfony\Component\Form\Form;

interface AgreementHandlerInterface
{
    /**
     * @param ContractingPartyInterface $contractingParty
     * @param string                    $termReference
     *
     * @return Agreement
     */
    public function createAgreement(ContractingPartyInterface $contractingParty, $termReference);

    /**
     * @param ContractingPartyInterface $contractingParty
     * @param string                    $termReference
     *
     * @return Agreement
     */
    public function getLastAgreement(ContractingPartyInterface $contractingParty, $termReference);

    /**
     * @param string $termReference
     *
     * @return Term
     */
    public function getCurrentTerm($termReference);

    /**
     * @param ContractingPartyInterface $contractingParty
     * @param string                    $termReference
     *
     * @return Agreement
     */
    public function getValidAgreement(ContractingPartyInterface $contractingParty, $termReference);

    /**
     * @param Form   $form
     * @param string $termReference
     * @param array  $options
     */
    public function formAddAgreement(Form $form, $termReference, $options);

    /**
     * @param Form   $form
     * @param string $termReference
     *
     * @return bool
     */
    public function formIsAgreementChecked(Form $form, $termReference);
}
