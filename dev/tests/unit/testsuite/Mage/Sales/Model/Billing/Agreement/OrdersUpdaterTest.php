<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Mage_Sales
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2012 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_Sales_Model_Billing_Agreement_OrdersUpdaterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_Sales_Model_Billing_Agreement_OrdersUpdater
     */
    protected $_object;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_registryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_argumentMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_agreementMock;

    protected function setUp()
    {
        $this->_argumentMock = $this->getMock(
            'Mage_Sales_Model_Resource_Order_Grid_Collection',
            array(),
            array(),
            '',
            false
        );

        $this->_agreementMock = $this->getMock(
            'Mage_Sales_Model_Billing_Agreement',
            array('getId'),
            array(),
            '',
            false
        );

        $this->_registryMock = $this->getMock(
            'Mage_Core_Model_Registry',
            array(),
            array(),
            '',
            false
        );

        $this->_object = new Mage_Sales_Model_Billing_Agreement_OrdersUpdater(
            array('registry' => $this->_registryMock)
        );
    }

    /**
     * @covers Mage_Sales_Model_Billing_Agreement_OrdersUpdater::update
     */
    public function testUpdate()
    {
        $this->_argumentMock->expects($this->once())
            ->method('addBillingAgreementsFilter')
            ->with(1);

        $this->_registryMock->expects($this->once())
            ->method('registry')
            ->with('current_billing_agreement')
            ->will($this->returnValue($this->_agreementMock));

        $this->_agreementMock->expects($this->once())->method('getId')->will($this->returnValue(1));

        $this->_object->update($this->_argumentMock);
    }

    /**
     * @covers Mage_Sales_Model_Billing_Agreement_OrdersUpdater::update
     * @expectedException DomainException
     */
    public function testUpdateWhenBillingAgreementIsNotSet()
    {
        $this->_argumentMock->expects($this->never())
            ->method('addBillingAgreementsFilter');

        $this->_agreementMock->expects($this->never())->method('getId');

        $this->_registryMock->expects($this->once())
            ->method('registry')
            ->with('current_billing_agreement')
            ->will($this->returnValue(null));

        $this->_object->update($this->_argumentMock);
    }
}
