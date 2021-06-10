<?php

namespace Maestriam\Samurai\Tests\Feature\Facade;

use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\Unit\Entities\Wizard\WizardTestCase;

class InitThemeTest extends WizardTestCase
{
    public function testInitTheme()
    {
        $name = 'bands/stage-dolls';

        $this->theme($name)->findOrCreate();

        $theme  = Samurai::wizard()->theme();
        $author = Samurai::wizard()->author();
        $descr  = Samurai::wizard()->description();

        $questions = [$author, $theme, $descr];

        foreach ($questions as $question) {
            $this->assertWizardQuestion($question);
        }

        $confirm = Samurai::wizard()->confirm(
            $theme->default, $author->default, $descr->default
        );

        $this->assertConfirmQuestion($confirm);
    }
}