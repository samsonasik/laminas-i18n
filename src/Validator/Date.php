<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\I18n\Validator;

use IntlDateFormatter;
use Traversable;
use Zend\I18n\Exception\InvalidArgumentException;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class Date extends DateTime
{

    const INVALID_DATE  = 'dateInvalidDate';

    protected $dateFormat = IntlDateFormatter::SHORT;
    protected $timeFormat = IntlDateFormatter::NONE;

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID_DATE   => "The input does not appear to be a valid date",
    );

    /**
     * Constructor for the Date validator
     *
     * @param array|Traversable $options
     */
    public function __construct($options = array())
    {
        if (!isset($options['messageTemplates'])) {
            $options['messageTemplates'] = $this->messageTemplates;
        }

        parent::__construct($options);
    }

    /**
     * @param int $timeFormat
     *
     * @return Date provides fluent interface
     */
    public function setTimeFormat($timeFormat)
    {
        throw new InvalidArgumentException(sprintf("'%s' is immutable for '%s'", 'timeFormat', __CLASS__));
    }

    /**
     * Returns true if and only if $value is a valid localized date string
     *
     * @param  string $value
     * @return bool
     * @throws Exception\InvalidArgumentException
     */
    public function isValid($value)
    {
        if (!$result = parent::isValid($value)) {
            // clear INVALID_DATETIME message and set INVALID_DATE
            if (array_key_exists(self::INVALID_DATETIME, $this->getMessages())) {
                $this->setValue($value);
                $this->error(self::INVALID_DATE);
                return false;
            }
        }

        return $result;
    }

}
