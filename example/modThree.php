<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use FSM\Alphabet\Letter;
use FSM\FSM\FSMArrayBuilder;
use FSM\FSM\FSMObjectBuilder;
use FSM\FSMService;
use FSM\State\FinalState;
use FSM\Transition\Transition;

/**
 * Mod-Three FA
 * Based on the notation from the definition, our modulo three FSM would be configured as
 * follows:
 * Q = (S0, S1, S2)
 * Σ = (0, 1)
 * q0 = S0
 * F = (S0, S1, S2)
 * δ(S0,0) = S0; δ(S0,1) = S1; δ(S1,0) = S2; δ(S1,1) = S0; δ(S2,0) = S1; δ(S2,1) = S2
 */

$state0 = new FinalState('S0', '0');
$state1 = new FinalState('S1', '1');
$state2 = new FinalState('S2', '2');

$letter0 = new Letter('0');
$letter1 = new Letter('1');

$fsmArrayBuilder = new FSMArrayBuilder();
$fsmArrayBuilder->createFSM();
$fsmArrayBuilder->setStates([$state0, $state1, $state2]);
$fsmArrayBuilder->setAlphabet([$letter0, $letter1]);
$fsmArrayBuilder->setInitState($state0);
$fsmArrayBuilder->setFinalState([$state0, $state1, $state2]);
$fsmArrayBuilder->setTransitions([
    new Transition($state0, $letter0, $state0),
    new Transition($state0, $letter1, $state1),
    new Transition($state1, $letter0, $state2),
    new Transition($state1, $letter1, $state0),
    new Transition($state2, $letter0, $state1),
    new Transition($state2, $letter1, $state2),
]);
$fsm = $fsmArrayBuilder->getFSM();

$fsmService = new FSMService($fsm);

// Example 1 - 110
echo "Example 1 - 110:\n";

$fsmService->processList([
    $letter1,
    $letter1,
    $letter0,
]);

echo 'Result: ';
echo $fsmService->getFinalOutput(). "\n\n";

// Example 2 - 1010

echo "Example 2 - 1010:\n";

$fsmService->reset();

$fsmService->processList([
    $letter1,
    $letter0,
    $letter1,
    $letter0,
]);

echo 'Result: ';
echo $fsmService->getFinalOutput(). "\n\n";

// Example 3 - 1100 1100 1010 1101 1001 1011

$fsmObjectBuilder = new FSMObjectBuilder();
$fsmObjectBuilder->createFSM();
$fsmObjectBuilder->addState($state0);
$fsmObjectBuilder->addState($state1);
$fsmObjectBuilder->addState($state2);
$fsmObjectBuilder->addLetter($letter0);
$fsmObjectBuilder->addLetter($letter1);
$fsmObjectBuilder->setInitState($state0);
$fsmObjectBuilder->addFinalState($state0);
$fsmObjectBuilder->addFinalState($state1);
$fsmObjectBuilder->addFinalState($state2);
$fsmObjectBuilder->addTransition(new Transition($state0, $letter0, $state0));
$fsmObjectBuilder->addTransition(new Transition($state0, $letter1, $state1));
$fsmObjectBuilder->addTransition(new Transition($state1, $letter0, $state2));
$fsmObjectBuilder->addTransition(new Transition($state1, $letter1, $state0));
$fsmObjectBuilder->addTransition(new Transition($state2, $letter0, $state1));
$fsmObjectBuilder->addTransition(new Transition($state2, $letter1, $state2));
$fsm = $fsmObjectBuilder->getFSM();

$fsmService = new FSMService($fsm);

echo "Example 3 - 1100 1100 1010 1101 1001 1011:\n";

$fsmService->reset();

$fsmService->processList([
    $letter1,
    $letter1,
    $letter0,
    $letter0,
    $letter1,
    $letter1,
    $letter0,
    $letter0,
    $letter1,
    $letter0,
    $letter1,
    $letter0,
    $letter1,
    $letter1,
    $letter0,
    $letter1,
    $letter1,
    $letter0,
    $letter0,
    $letter1,
    $letter1,
    $letter0,
    $letter1,
    $letter1,
]);

echo 'Result: ';
echo $fsmService->getFinalOutput(). "\n";
