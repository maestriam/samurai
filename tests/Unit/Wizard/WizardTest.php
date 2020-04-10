<?php

namespace Maestriam\Samurai\Tests\Unit\Wizard;

use stdClass;
use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;

class WizardTest extends TestCase
{
    use Themeable;

    public function testDescriptionQuestion()
    {
        $question = $this->wizard()->theme();    
        
        $this->assertInstanceOf(stdClass::class, $question);

        $this->assertObjectHasAttribute('ask', $question);
        $this->assertObjectHasAttribute('default', $question);

        $this->assertIsString($question->ask);
        $this->assertIsString($question->default);
    }
}