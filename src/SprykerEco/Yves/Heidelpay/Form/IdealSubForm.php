<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Yves\Heidelpay\Form;

use SprykerEco\Shared\Heidelpay\HeidelpayConfig;

class IdealSubForm extends AbstractHeidelpaySubForm
{
    public const PAYMENT_METHOD = HeidelpayConfig::PAYMENT_METHOD_IDEAL;
    public const PAYMENT_METHOD_TEMPLATE_PATH = 'ideal';
}
