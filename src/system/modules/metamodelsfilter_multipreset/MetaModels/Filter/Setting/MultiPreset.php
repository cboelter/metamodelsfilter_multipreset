<?php
/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package	   MetaModels
 * @subpackage Interfaces
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

namespace MetaModels\Filter\Setting;

use MetaModels\FrontendIntegration\FrontendFilterOptions;
use MetaModels\IItem;
use MetaModels\Filter\IFilter;
use MetaModels\Filter\Rules\StaticIdList as FilterRuleStaticIdList;
use MetaModels\Filter\Rules\SearchAttribute as FilterRuleSimpleLookup;
use MetaModels\Render\Setting\ICollection as IRenderSettings;
use MetaModels\Filter\Rules\SearchAttribute;
use MetaModels\Filter\Rules\Condition\ConditionOr;
use MetaModels\Filter\Filter;

/**
 * Filter setting implementation performing a search for a value on a
 * configured attribute.
 *
 * @package	   MetaModels
 * @subpackage Core
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 */
class MultiPreset extends Simple
{
	/**
	 * {@inheritdoc}
	 */
	protected function getParamName()
	{
		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));
		if ($objAttribute)
		{
			return $objAttribute->getColName();
		}

		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function prepareRules(IFilter $objFilter, $arrFilterUrl)
	{
		$objMetaModel = $this->getMetaModel();
		$objAttribute = $objMetaModel->getAttributeById($this->get('attr_id'));
		$strParam = $this->getParamName();

		if ($objAttribute && $strParam)
		{
			$arrFilterValue = $arrFilterUrl[$strParam];

			if ($arrFilterValue)
			{
				if(is_array($arrFilterValue) && count($arrFilterValue) > 1)
				{
					$objParentRule = new ConditionOr();

					foreach($arrFilterValue as $strValue) {
						$objSubFilter = new Filter($objMetaModel);
						$objSubFilter->addFilterRule(new SearchAttribute($objAttribute, $strValue));
						$objParentRule->addChild($objSubFilter);
					}

					$objFilter->addFilterRule($objParentRule);
					return;

				} else {
					$objFilter->addFilterRule(new SearchAttribute($objAttribute, $arrFilterValue));
					return;
				}
			}


			$objFilter->addFilterRule(new FilterRuleStaticIdList(NULL));
			return;
		}
		// either no attribute found or no match in url, do not return anything.
		$objFilter->addFilterRule(new FilterRuleStaticIdList(array()));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParameters()
	{
		return ($strParamName = $this->getParamName()) ? array($strParamName) : array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParameterDCA()
	{
		$objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));
		$arrOptions = $objAttribute->getFilterOptions(NULL, true);

		array_insert($arrOptions, 0, array(
			'' => '-'
		));

		return array(
			$this->getParamName() => array
			(
				'label'   => array(
					sprintf($GLOBALS['TL_LANG']['MSC']['metamodel_filtersettings_parameter']['simplelookup'][0], $objAttribute->getName()),
					sprintf($GLOBALS['TL_LANG']['MSC']['metamodel_filtersettings_parameter']['simplelookup'][1], $objAttribute->getName())
				),
				'inputType'    => 'select',
				'options' => $arrOptions,
				'eval' => array('includeBlankOption' => true, 'multiple' => true, 'style' => 'min-width:450px;margin-bottom:16px;margin-right:10px;')
			)
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getReferencedAttributes()
	{
		if (!($this->get('attr_id') && ($objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id')))))
		{
			return array();
		}
		return array($objAttribute->getColName());
	}
}