<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Wizard;

use Maestriam\Samurai\Tests\TestCase;
use stdClass;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class WizardTestCase extends TestCase
{
    protected function assertWizardQuestion($question)
    {
        $this->assertInstanceOf(stdClass::class, $question);
        $this->assertObjectHasAttribute('ask', $question);
        $this->assertObjectHasAttribute('default', $question);
        $this->assertIsString($question->ask);
        $this->assertIsString($question->default);
    }
    
    protected function assertConfirmQuestion($question)
    {
        $this->assertInstanceOf(stdClass::class, $question);
        $this->assertObjectHasAttribute('ask', $question);
        $this->assertObjectHasAttribute('default', $question);
        $this->assertIsString($question->ask);
        $this->assertIsBool($question->default);
        $this->assertFalse($question->default);
    }
}