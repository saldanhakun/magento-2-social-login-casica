<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_SocialLogin
 * @copyright   Copyright (c) 2016 Mageplaza (http://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */
namespace Mageplaza\SocialLogin\Block\Popup;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mageplaza\SocialLogin\Helper\Social as SocialHelper;

/**
 * Class Social
 * @package Mageplaza\SocialLogin\Block\Popup
 */
class Social extends Template
{
	const SOCIALS_LIST = [
		'facebook'   => 'Facebook',
		'google'     => 'Google',
		'twitter'    => 'Twitter',
		'linkedin'   => 'LinkedIn',
		'yahoo'      => 'Yahoo',
		'foursquare' => 'Foursquare',
		'vkontakte'  => 'Vkontakte',
		'instagram'  => 'Instagram',
		'github'     => 'Github',
	];

	/**
	 * @type \Mageplaza\SocialLogin\Helper\Social
	 */
	protected $socialHelper;

	/**
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param \Mageplaza\SocialLogin\Helper\Social $socialHelper
	 * @param array $data
	 */
	public function __construct(
		Context $context,
		SocialHelper $socialHelper,
		array $data = []
	)
	{
		$this->socialHelper = $socialHelper;

		parent::__construct($context, $data);
	}

	/**
	 * @return array
	 */
	public function getAvailableSocials()
	{
		$availabelSocials = [];

		foreach (self::SOCIALS_LIST as $socialKey => $socialLabel) {
			$helper = $this->socialHelper->correctXmlPath($socialKey);
			if ($helper->isEnabled()) {
				$availabelSocials[$socialKey] = new \Magento\Framework\DataObject([
					'label'     => $socialLabel,
					'login_url' => $this->getLoginUrl($socialKey),
				]);
			}
		}

		return $availabelSocials;
	}

	/**
	 * @param $key
	 * @return string
	 */
	public function getBtnKey($key)
	{
		switch ($key) {
			case 'vkontakte':
				$class = 'vk';
				break;
			default:
				$class = $key;
		}

		return $class;
	}

	/**
	 * @param $socialKey
	 * @return string
	 */
	public function getLoginUrl($socialKey)
	{
		return $this->getUrl('sociallogin/login/' . $socialKey);
	}
}
