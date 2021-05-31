<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Vendor;

use Maestriam\Samurai\Entities\Vendor;
use Maestriam\Samurai\Entities\Wizard;
use Maestriam\Samurai\Tests\TestCase;
use stdClass;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class WizardTestCase extends TestCase
{
    /**
     * Verifica se consegue retorna a pergunta e sua resposta 
     * padrão sobre o vendor/nome-do-tema
     *
     * @return void
     */
    public function testThemeQuestion()
    {
        $wizard = new Wizard();

        $question = $wizard->theme();

        $this->assertWizardQuestion($question);
    }

    public function testDescriptionQuestion()
    {
        $wizard = new Wizard();

        $question = $wizard->description();

        $this->assertWizardQuestion($question);
    }

    public function testAuthorQuestion()
    {
        $wizard = new Wizard();

        $question = $wizard->author();

        $this->assertWizardQuestion($question);
    }

    public function testConfirmQuestion()
    {
        $wizard = new Wizard();

        $name   = 'Dave Mustaine';
        $email  = 'mustaine@megadeth.com';
        $vendor = 'bands/megadeth';
        $author = "$name <$email>";
        $descr  = 'Rust In Peace Theme';

        $question = $wizard->confirm($vendor, $author, $descr);

        $this->assertConfirmQuestion($question);
        $this->assertStringContainsString($vendor, $question->ask);
        $this->assertStringContainsString($name, $question->ask);
        $this->assertStringContainsString($email, $question->ask);
        $this->assertStringContainsString($descr, $question->ask);
    }

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