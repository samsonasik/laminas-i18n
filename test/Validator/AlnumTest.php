<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Validator;

use Laminas\I18n\Validator\Alnum as AlnumValidator;

/**
 * @category   Laminas
 * @package    Laminas_Validator
 * @subpackage UnitTests
 * @group      Laminas_Validator
 */
class AlnumTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AlnumValidator
     */
    protected $validator;

    /**
     * Creates a new Alnum object for each test method
     *
     * @return void
     */
    public function setUp()
    {
        $this->validator = new AlnumValidator();
    }

    /**
     * Ensures that the validator follows expected behavior for basic input values
     *
     * @return void
     */
    public function testExpectedResultsWithBasicInputValues()
    {
        $valuesExpected = array(
            'abc123'  => true,
            'abc 123' => false,
            'abcxyz'  => true,
            'AZ@#4.3' => false,
            'aBc123'  => true,
            ''        => false,
            ' '       => false,
            "\n"      => false,
            'foobar1' => true
        );
        foreach ($valuesExpected as $input => $result) {
            $this->assertEquals($result, $this->validator->isValid($input));
        }
    }

    /**
     * Ensures that getMessages() returns expected initial value
     *
     * @return void
     */
    public function testMessagesEmptyInitially()
    {
        $this->assertEquals(array(), $this->validator->getMessages());
    }

    /**
     * Ensures that the allowWhiteSpace option works as expected
     *
     * @return void
     */
    public function testOptionToAllowWhiteSpaceWithBasicInputValues()
    {
        $this->validator->setAllowWhiteSpace(true);

        $valuesExpected = array(
            'abc123'  => true,
            'abc 123' => true,
            'abcxyz'  => true,
            'AZ@#4.3' => false,
            'aBc123'  => true,
            ''        => false,
            ' '       => true,
            "\n"      => true,
            " \t "    => true,
            'foobar1' => true
            );
        foreach ($valuesExpected as $input => $result) {
            $this->assertEquals(
                $result,
                $this->validator->isValid($input),
                "Expected '$input' to be considered " . ($result ? '' : 'in') . "valid"
                );
        }
    }

    /**
     * @return void
     */
    public function testEmptyStringValueResultsInProperValidationFailureMessages()
    {
        $this->assertFalse($this->validator->isValid(''));

        $messages = $this->validator->getMessages();
        $arrayExpected = array(
            AlnumValidator::STRING_EMPTY => 'The input is an empty string'
        );
        $this->assertThat($messages, $this->identicalTo($arrayExpected));
    }

    /**
     * @return void
     */
    public function testInvalidValueResultsInProperValidationFailureMessages()
    {
        $this->assertFalse($this->validator->isValid('#'));
        $messages = $this->validator->getMessages();
        $arrayExpected = array(
            AlnumValidator::NOT_ALNUM => 'The input contains characters which are non alphabetic and no digits'
        );
        $this->assertThat($messages, $this->identicalTo($arrayExpected));
    }

    /**
     * @Laminas-4352
     */
    public function testNonStringValidation()
    {
        $this->assertFalse($this->validator->isValid(array(1 => 1)));
    }

    /**
     * @Laminas-7475
     */
    public function testIntegerValidation()
    {
        $this->assertTrue($this->validator->isValid(1));
    }

    public function testEqualsMessageTemplates()
    {
        $validator = $this->validator;
        $this->assertAttributeEquals($validator->getOption('messageTemplates'),
                                     'messageTemplates', $validator);
    }
}
