<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Heidelpay\Business\DataProviders\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Customer\Persistence\SpyCustomer;

trait CustomerTrait
{

    /**
     * @var array
     */
    private $uniqueCustomerEmailSlugs = [];

    /**
     * @var \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    private $johnDoeEntity;

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    public function createOrGetCustomerJohnDoe()
    {
        return $this->createCustomer('John', 'Doe');
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    public function createOrGetCustomerByQuote(QuoteTransfer $quoteTransfer)
    {
        return $this->createCustomer(
            $quoteTransfer->getCustomer()->getFirstName(),
            $quoteTransfer->getCustomer()->getLastName()
        );
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function createCustomerJohnDoeTransfer()
    {
        $johnDoeEntity = $this->createOrGetCustomerJohnDoe();

        $johnDoeTransfer = (new CustomerTransfer())
            ->fromArray($johnDoeEntity->toArray(), true);

        return $johnDoeTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function createCustomerJohnDoeGuestTransfer()
    {
        $johnDoeTransfer = $this->createCustomerJohnDoeTransfer();

        $johnDoeTransfer->setIsGuest(true)
            ->setIdCustomer(null);

        return $johnDoeTransfer;
    }

    /**
     * @param string $firstName
     * @param string $lastName
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    private function createCustomer($firstName, $lastName)
    {
        if ($this->johnDoeEntity === null) {
            $customer = (new SpyCustomer())
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setEmail($this->getUniqueCustomerEmail($firstName . $lastName))
                ->setDateOfBirth('1970-01-01')
                ->setGender(SpyCustomerTableMap::COL_GENDER_MALE)
                ->setCustomerReference('heidelpay-test-' . $this->getUniqueCustomerEmail($firstName . $lastName));
            $customer->save();

            $this->johnDoeEntity = $customer;
        }

        return $this->johnDoeEntity;
    }

    /**
     * @param string $emailSlug
     *
     * @return string
     */
    private function getUniqueCustomerEmail($emailSlug)
    {
        if (!isset($this->uniqueCustomerEmailSlugs[$emailSlug])) {
            $this->uniqueCustomerEmailSlugs[$emailSlug] = uniqid($emailSlug) . '@test.com';
        }

        return $this->uniqueCustomerEmailSlugs[$emailSlug];
    }

}
