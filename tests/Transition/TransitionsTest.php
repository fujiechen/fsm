<?php

declare(strict_types=1);

namespace Tests\Transition;

use Exception;
use FSM\Alphabet\Alphabet;
use FSM\Alphabet\Letter;
use FSM\State\State;
use FSM\State\States;
use FSM\Transition\Transition;
use FSM\Transition\Transitions;
use PHPUnit\Framework\TestCase;

class TransitionsTest extends TestCase
{
    public function testConstructorWithCorrectInstanceType()
    {
        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $res = new Transitions($transitions);

        $this->assertInstanceOf(Transitions::class, $res);
    }

    public function testConstructorWithIncorrectInstanceType()
    {
        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new State('S2'),
        ];

        $this->expectExceptionMessage(Exception::class);
        $this->expectExceptionMessage(Transitions::VALIDATE_INIT_TRANSITIONS_OBJECT_EXCEPTION_MESSAGE);

        $res = new Transitions($transitions);
    }

    public function testGetTransitions()
    {
        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);
        $res = $transitions->getTransitions();

        $this->assertIsArray($res);
        $this->assertInstanceOf(Transition::class, $res[0]);
        $this->assertInstanceOf(State::class, $res[0]->getState());
        $this->assertEquals('S1', $res[0]->getState()->getName());
    }

    public function testValidateFailByWrongState()
    {
        $states = new States([new State('S1'), new State('S3')]);
        $alphabet = new Alphabet([new Letter('1'), new Letter('2')]);

        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S3')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);

        $this->expectExceptionMessage(Transitions::VALIDATE_INIT_TRANSITIONS_WRONG_STATE_EXCEPTION_MESSAGE);

        $transitions->validate($states, $alphabet);
    }

    public function testValidateFailByWrongDestination()
    {
        $states = new States([new State('S1'), new State('S2')]);
        $alphabet = new Alphabet([new Letter('1'), new Letter('2')]);

        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S3')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);

        $this->expectExceptionMessage(Transitions::VALIDATE_INIT_TRANSITIONS_WRONG_DESTINATION_EXCEPTION_MESSAGE);

        $transitions->validate($states, $alphabet);
    }

    public function testValidateFailByWrongInput()
    {
        $states = new States([new State('S1'), new State('S2'), new State('S3')]);
        $alphabet = new Alphabet([new Letter('1'), new Letter('3')]);

        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);

        $this->expectExceptionMessage(Transitions::VALIDATE_INIT_TRANSITIONS_WRONG_ALPHABET_EXCEPTION_MESSAGE);

        $transitions->validate($states, $alphabet);
    }

    public function testValidatePass()
    {
        $states = new States([new State('S1'), new State('S2'), new State('S3')]);
        $alphabet = new Alphabet([new Letter('1'), new Letter('2')]);

        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);

        $res = $transitions->validate($states, $alphabet);

        $this->assertTrue($res);
    }

    public function testFindByStateAndLetterNotFound()
    {
        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S1'), new Letter('2'), new State('S3')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);

        $res = $transitions->findByStateAndLetter(new State('S1'), new Letter('3'));

        $this->assertNull($res);
    }

    public function testFindByStateAndLetterAndReturnTheFoundTransition()
    {
        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S1'), new Letter('2'), new State('S3')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);

        $res = $transitions->findByStateAndLetter(new State('S1'), new Letter('2'));

        $this->assertInstanceOf(Transition::class, $res);
        $this->assertEquals('S1', $res->getState()->getName());
        $this->assertEquals('2', $res->getInput()->getValue());
        $this->assertEquals('S3', $res->getDestination()->getName());
    }

    public function testPush()
    {
        $transitions = [
            new Transition(new State('S1'), new Letter('1'), new State('S2')),
            new Transition(new State('S2'), new Letter('2'), new State('S3')),
        ];

        $transitions = new Transitions($transitions);

        $transitions->push(new Transition(new State('S3'), new Letter('3'), new State('S4')));

        $res = $transitions->getTransitions();

        $this->assertCount(3, $res);
        $this->assertEquals('S3', $res[2]->getState()->getName());
        $this->assertEquals('3', $res[2]->getInput()->getValue());
        $this->assertEquals('S4', $res[2]->getDestination()->getName());
    }
}
