# Finite State Machine

## Table of Content
* [Overview](#overview)
* [Technical Aspect](#technical-aspect)
  * [Requirement](#requirement)
  * [File Structure](#file-structure)
  * [Class Structure](#class-structure)
  * [Procedure](#procedure)
* [Tests](#tests)
* [Demo](#demo)


## Overview
Create a software module for generating an FSM (Finite State Machine). The API of the library is designed for use by other developers. The library(class) is fully test covered. The 'mod-three' procedure is the demo for the FSM. 

## Technical Aspect

### Requirement
- PHP 8.1
  - Xdebug (if run code coverage)
- composer
- PHPUnit

### File Structure

- `/src` is the core library
  - The main class is named as `FSM` in `FSM.php` file
- `/tests` is the PHPUnit test suite
- `/example` is the example/demo of the FSM by implementing mod-three procedure

### Class Structure

- FSM: the finite state machine
  - Alphabet: Letter object set
    - Letter: Accepting letter in FSM, implemented Comparable interface
  - States: State object set
    - State: Accepting state with its name, implemented Comparable interface
  - FinalStates: FinalState objects set, extended from States
    - FinalState: Accepting state with its name and output, extended from State, implemented Comparable interface
  - Transitions: Transition object set
    - Transition: Accepting transition with its state(State), input(Letter), and destination(State)
  - Comparable interface: provide standard interface method to compare between objects

### Procedure

- Use either FSM constructor or the builder to build the FSM with 
  - A finite set of states
  - A finite input alphabet
  - The initial state
  - The set of accepting/final states
  - The transition function
- Provide one or a list of Letters as input, and process the FSM
- Print the finial output if available
- Reset or continue process more input(s)

## Tests

The test suite uses PHPUnit v9. All test files are under the `tests` folder.

To run the test suite, please make sure install all dependencies via composer, then run command to see the detail result

```zsh
./vendor/bin/phpunit --testdox
```

![php_test](./docs/php_test.png)

### Test Code Coverage

Make sure the php on local machine has Xdebug, then config IDE (the screenshot uses PHPStorm) to have PHPUnit and Xdebug setup properly.
Run the code coverage based on phpunit.xml config file and check the result

The Test is covering **100%** source code under src folder.

![php_codecoverage](./docs/php_code_coverage.png)

## Demo

1. Make sure php v8.1 and composer v3 is installed
2. Run `composer install` on project root to have fresh autoload
3. Go to project root, `cd example`, then `php mod_three.php`

The demo initiate 3 states, and 2 letters, then use FSM Builder to make an instance.
The demo then calls `processList` with letter list to reproduce the 2 examples from the instruction document
The demo also add a 24 digit binary number for extra testing

![demo](./docs/demo.png)
