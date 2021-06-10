<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Wizard;

use Maestriam\Samurai\Entities\Wizard;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class GetQuestionsTest extends WizardTestCase
{
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
}