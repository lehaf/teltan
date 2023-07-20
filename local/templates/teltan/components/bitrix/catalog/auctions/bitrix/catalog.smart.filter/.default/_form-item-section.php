<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arCur */
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$checkedItemExist = false;
?><div class="form-item">
	<label class="zag"><span><?= $arCur['LABEL'] ?></span></label>
	<div class="smart-filter-input-group-dropdown">
		<div class="smart-filter-dropdown-block" onclick="smartFilter.showDropDownPopup(this, '<?= $arCur['CONTROL_ID'] ?>')">
			<div class="smart-filter-dropdown-text" data-role="currentOption">
				<? foreach ($arCur['SECTIONS_LIST'] as $arSection)
				{
					if (!empty($arResult['SECTIONS_CHAIN'][$arSection['ID']]))
					{
						echo $arSection["NAME"];
						$arCur['CURRENT_SECTION_ID'] = $arSection['ID'];
						$checkedItemExist = true;
					}
				}
				if (!$checkedItemExist)
				{
					echo GetMessage("CT_BCSF_FILTER_ALL");
				}
				?>
			</div>
			<div class="smart-filter-dropdown-arrow"></div>
			<?foreach ($arCur['SECTIONS_LIST'] as $arSection) { ?>
				<input
					style="display: none"
					type="radio"
					name="<?= $arCur['CONTROL_ID'] ?>"
					id="<?= "{$arCur['CONTROL_ID']}_{$arSection['ID']}" ?>"
					value="<?= $arSection['SECTION_PAGE_URL'] ?>"
					<? echo !empty($arResult['SECTIONS_CHAIN'][$arSection['ID']])?'selected':''? 'checked="checked"': '' ?>
				/>
			<? } ?>
			<div class="smart-filter-dropdown-popup" data-role="dropdownContent" style="display: none;">
				<ul>
					<li style="display: none;">
						<label for="<?= "all_{$arCur['CONTROL_ID']}" ?>"
						       class="smart-filter-dropdown-label"
						       data-role="<?= "label_all_{$arCur['CONTROL_ID']}" ?>"
						       onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_{$arCur['CONTROL_ID']}")?>')">
							<?=GetMessage("CT_BCSF_FILTER_ALL"); ?>
						</label>
					</li>
					<?foreach ($arCur['SECTIONS_LIST'] as $arSection) {
						$class = "";
						if ( !empty($arResult['SECTIONS_CHAIN'][$arSection['ID']])?'selected':'')
							$class.= " selected";
						if ($arSection["DISABLED"])
							$class.= " disabled";
						?>
						<li>
							<label for="<?= "{$arCur['CONTROL_ID']}_{$arSection['ID']}" ?>"
							       class="smart-filter-dropdown-label<?=$class?>"
							       data-role="<?= "label_{$arCur['CONTROL_ID']}_{$arSection['ID']}" ?>"
							       onclick="smartFilter.selectDropDownSectionItem(this, '<?=CUtil::JSEscape("{$arCur['CONTROL_ID']}_{$arSection['ID']}")?>')">
								<?=$arSection['NAME']?>
							</label>
						</li>
					<? } ?>
				</ul>
			</div>
		</div>
	</div>
</div>