<?php
/**
 * @package        Joomla.UnitTest
 * @subpackage     AccessiblemediaField
 *
 * @copyright      Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Tests\Unit\Libraries\Cms\Form\Field;

use Joomla\CMS\Form\Field\AccessiblemediaField;

/**
 * Test class for AccessiblemediaField.
 *
 * @package     Joomla.UnitTest
 * @subpackage  Form
 * @since       __DEPLOY_VERSION__
 */
class AccessiblemediaFieldTest extends \PHPUnit\Framework\TestCase
{
	/**
	 * Tests the constructor
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testIsConstructable()
	{
		$this->assertInstanceOf(AccessiblemediaField::class, $this->createAccessiblemediaField());
	}

	/**
	 * Tests getting a property.
	 * If no value has been set yet, the default values should be returned: Mostly null
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testGetWithDefaultValues()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();
		$properties = array(
			"type" => 'Accessiblemedia',
			"directory" => null,
			"preview" => null,
			"previewWidth" => null,
			"previewHeight" => null,
			"didnotexist" => null,
			"layout" => null,
		);

		foreach ($properties as $property => $propertyvalue)
		{
			$this->assertEquals($propertyvalue, $accessiblemediafield->__get($property));
		}
	}

	/**
	 * Tests setting and getting a property.
	 * A property that was set with set should be returned with get.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testSetAndGetShouldBeEquals()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();
		$properties = array(
			"directory" => 'mydirectory',
			"preview" => 'tooltip',
			"previewWidth" => "300",
			"previewHeight" => "300",
			"layout" => 'joomla.form.field.media.accessiblemedia',
		);

		foreach ($properties as $property => $propertyvalue)
		{
			$accessiblemediafield->__set($property, $propertyvalue);
			$this->assertEquals($propertyvalue, $accessiblemediafield->__get($property));
		}
	}

	/**
	 * Tests setting and getting a property.
	 * A property is used here that is not supported by the field.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testSetAndGetShouldNotBeEquals()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();
		$properties = array(
			"didnotexist" => "thisshouldbenull",
		);

		foreach ($properties as $property => $propertyvalue)
		{
			$accessiblemediafield->__set($property, $propertyvalue);
			$this->assertNotEquals($propertyvalue, $accessiblemediafield->__get($property));
		}
	}

	/**
	 * Tests method to attach a Form object to the field.
	 * If no image file is selected, the value is an empty string.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testSetupWithEmptyValue()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();

		$element = new \SimpleXMLElement('<field name="testfield" />');

		$this->assertTrue($accessiblemediafield->setup($element, '', null));
		$this->assertEquals('', $accessiblemediafield->__get('value'));
	}

	/**
	 * Tests method to attach a Form object to the field.
	 * If a image file is selected but no alt text, the value is a simple string - the filename.
	 * This does change in the setup method. Result should be an array.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testSetupWithValueThatIsValidButNotAccessible()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();

		$element = new \SimpleXMLElement('<field name="testfield" />');
		$fieldvalue = array(
			"imagefile" => '/images/joomla_black.png',
			"alt_text" => '',
		);

		$this->assertTrue($accessiblemediafield->setup($element, '/images/joomla_black.png', null));
		$this->assertEquals($fieldvalue, $accessiblemediafield->__get('value'));
	}

	/**
	 * Tests method to attach a Form object to the field.
	 * If a image file is selected and an alt text, the value is a JSON-string.
	 * The value is available as an array in the field.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testSetupWithValueThatIsValid()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();

		$element = new \SimpleXMLElement('<field name="testfield" />');
		$fieldvalue = array(
			"imagefile" => 'pathtofile',
			"alt_text" => 'alt text',
		);

		$this->assertTrue($accessiblemediafield->setup($element, '{"imagefile":"pathtofile","alt_text":"alt text"}', null));
		$this->assertEquals($fieldvalue, $accessiblemediafield->__get('value'));
	}

	/**
	 * Tests method to attach a Form object to the field.
	 * If the value is a simple string that is no valid filename.
	 * This does change in the setup method. Result should be an empty string.

	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testSetupWithValueThatIsNotValid()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();

		$element = new \SimpleXMLElement('<field name="testfield" />');

		$this->assertTrue($accessiblemediafield->setup($element, 'jfsdkl', null));
		$this->assertEquals('', $accessiblemediafield->__get('value'));
	}

	/**
	 * Tests method to attach a Form object to the field.
	 * If the SimpleXMLElement is not of the field type, the setup method returns false.
	 *
	 * @return  void
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function testSetupWithElementIsNoField()
	{
		$accessiblemediafield = $this->createAccessiblemediaField();

		$element = new \SimpleXMLElement('<Nofield name="testfield" />');

		$this->assertFalse($accessiblemediafield->setup($element, '', null));
	}

	/**
	 * Helper function to create a AccessiblemediaField
	 *
	 * @return  AccessiblemediaField
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	protected function createAccessiblemediaField(): AccessiblemediaField
	{
		return new AccessiblemediaField;
	}
}
