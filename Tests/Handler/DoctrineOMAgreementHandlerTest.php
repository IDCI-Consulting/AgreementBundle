<?php

namespace IDCI\Bundle\AgreementBundle\Tests\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use IDCI\Bundle\AgreementBundle\Exception\ContractingPartyNotAgreeTermException;
use IDCI\Bundle\AgreementBundle\Exception\NoValidAgreementException;
use IDCI\Bundle\AgreementBundle\Exception\UndefinedTermException;
use IDCI\Bundle\AgreementBundle\Handler\DoctrineOMAgreementHandler;
use IDCI\Bundle\AgreementBundle\Model\Agreement;
use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;
use IDCI\Bundle\AgreementBundle\Model\Term;
use IDCI\Bundle\AgreementBundle\Repository\Doctrine\DoctrineORMAgreementRepository;
use IDCI\Bundle\AgreementBundle\Repository\Doctrine\DoctrineORMTermRepository;
use PHPUnit\Framework\TestCase;

class DoctrineOMAgreementHandlerTest extends TestCase
{
    private $om;
    private $agreementRepository;
    private $termRepository;

    public function setUp()
    {
        $this->agreementRepository = $this->createMock(DoctrineORMAgreementRepository::class);
        $this->termRepository = $this->createMock(DoctrineORMTermRepository::class);

        $this->om = $this->createMock(ObjectManager::class);
        $this->om
            ->method('getRepository')
            ->willReturnMap([
                [Term::class, $this->termRepository],
                [Agreement::class, $this->agreementRepository],
            ])
        ;
    }

    public function testCreateAgreement()
    {
        $currentTerm = $this->createMock(Term::class);

        $this->om
            ->expects($this->once())
            ->method('persist')
        ;
        $this->om
            ->expects($this->once())
            ->method('flush')
        ;

        $agreementHandler = $this->getMockBuilder(DoctrineOMAgreementHandler::class)
            ->setConstructorArgs([$this->om])
            ->setMethods(['getCurrentTerm'])
            ->getMock()
        ;
        $agreementHandler
            ->method('getCurrentTerm')
            ->will($this->returnValue($currentTerm))
        ;

        $contractingParty = $this->createMock(ContractingPartyInterface::class);
        $termReference = 'a term reference';

        $this->assertInstanceOf(
            Agreement::class,
            $agreementHandler->createAgreement($contractingParty, $termReference)
        );
    }

    public function testGetLastAgreement()
    {
        $lastAgreement = $this->createMock(Agreement::class);

        $this->agreementRepository
            ->method('findLastByTermReference')
            ->will($this->returnValue($lastAgreement))
        ;

        $agreementHandler = $this->getMockBuilder(DoctrineOMAgreementHandler::class)
            ->setConstructorArgs([$this->om])
            ->setMethods(null)
            ->getMock()
        ;

        $contractingParty = $this->createMock(ContractingPartyInterface::class);
        $termReference = 'a term reference';

        $this->assertEquals(
            $lastAgreement,
            $agreementHandler->getLastAgreement($contractingParty, $termReference)
        );
    }

    public function testGetLastAgreementNotAgreeTerm()
    {
        $agreementHandler = $this->getMockBuilder(DoctrineOMAgreementHandler::class)
            ->setConstructorArgs([$this->om])
            ->setMethods(null)
            ->getMock()
        ;

        $contractingParty = $this->createMock(ContractingPartyInterface::class);
        $termReference = 'a term reference';

        $this->expectException(ContractingPartyNotAgreeTermException::class);
        $agreementHandler->getLastAgreement($contractingParty, $termReference);
    }

    public function testGetCurrentTerm()
    {
        $currentTerm = $this->createMock(Agreement::class);

        $this->termRepository
            ->method('findCurrent')
            ->will($this->returnValue($currentTerm))
        ;

        $termHandler = $this->getMockBuilder(DoctrineOMAgreementHandler::class)
            ->setConstructorArgs([$this->om])
            ->setMethods(null)
            ->getMock()
        ;

        $termReference = 'a term reference';

        $this->assertEquals(
            $currentTerm,
            $termHandler->getCurrentTerm($termReference)
        );
    }

    public function testGetCurrentTermUndefined()
    {
        $termHandler = $this->getMockBuilder(DoctrineOMAgreementHandler::class)
            ->setConstructorArgs([$this->om])
            ->setMethods(null)
            ->getMock()
        ;

        $termReference = 'a term reference';

        $this->expectException(UndefinedTermException::class);
        $termHandler->getCurrentTerm($termReference);
    }

    public function testGetValidAgreement()
    {
        $currentTerm = $this->createMock(Agreement::class);
        $lastAgreement = $this->createMock(Agreement::class);
        $lastAgreement
            ->method('getTerm')
            ->will($this->returnValue($currentTerm))
        ;

        $termHandler = $this->getMockBuilder(DoctrineOMAgreementHandler::class)
            ->setConstructorArgs([$this->om])
            ->setMethods(['getCurrentTerm', 'getLastAgreement'])
            ->getMock()
        ;
        $termHandler
            ->method('getCurrentTerm')
            ->will($this->returnValue($currentTerm))
        ;
        $termHandler
            ->method('getLastAgreement')
            ->will($this->returnValue($lastAgreement))
        ;

        $contractingParty = $this->createMock(ContractingPartyInterface::class);
        $termReference = 'a term reference';

        $this->assertEquals(
            $lastAgreement,
            $termHandler->getValidAgreement($contractingParty, $termReference)
        );
    }

    public function testGetValidAgreementNoValid()
    {
        $currentTerm = $this->createMock(Agreement::class);
        $lastAgreement = $this->createMock(Agreement::class);
        $anotherAgreement = $this->createMock(Agreement::class);
        $lastAgreement
            ->method('getTerm')
            ->will($this->returnValue($anotherAgreement))
        ;

        $termHandler = $this->getMockBuilder(DoctrineOMAgreementHandler::class)
            ->setConstructorArgs([$this->om])
            ->setMethods(['getCurrentTerm', 'getLastAgreement'])
            ->getMock()
        ;
        $termHandler
            ->method('getCurrentTerm')
            ->will($this->returnValue($currentTerm))
        ;
        $termHandler
            ->method('getLastAgreement')
            ->will($this->returnValue($lastAgreement))
        ;

        $contractingParty = $this->createMock(ContractingPartyInterface::class);
        $termReference = 'a term reference';

        $this->expectException(NoValidAgreementException::class);
        $termHandler->getValidAgreement($contractingParty, $termReference);
    }
}
