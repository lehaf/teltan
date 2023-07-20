<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
CModule::IncludeModule('iblock');
$APPLICATION->SetTitle("Поиск");
$arOrder = array("DATE_CREATE" => "DESC");
if ($_GET['sort'] == 'price_a') {
	$arOrder = array('PROPERTY_PRICE' => 'ASC');
}
if ($_GET['sort'] == 'price_d') {
	$arOrder = array('PROPERTY_PRICE' => 'DESC');
}
if ($_GET['sort'] == 'popular') {
	$arOrder = array('SHOW_COUNTER' => 'DESC');
}
$arResult = [];
$arSelect = array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", 'PREVIEW_PICTURE', 'DETAIL_PAGE_URL', 'SHOW_COUNTER', 'PROPERTY_TIME_RISE', 'DATE_CREATE', 'ACTIVE');
$arFilter = array("IBLOCK_ID" => IntVal($_GET['R']), "ACTIVE" => "Y", "PROPERTY_ID_USER" => $_GET['I']);
$res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
while ($ob = $res->GetNextElement()) {
	static $counter;
	$arFields = $ob->GetFields();
	$arResult['ITEMS'][$counter] = $arFields;
	$arProps = $ob->GetProperties();
	$arResult['ITEMS'][$counter]['PROPERTIES'] = $arProps;
	$counter++;
}


if($arResult['ITEMS']){
?>
	<div class="container">
		<h1 class="h2 mb-4 subtitle">
			<?=$APPLICATION->ShowTitle();?>
		</h1>

		<div class="mb-5 row d-flex align-items-center">
			<?=$arResult['NAV_STRING'];?>

			<div class="col-12 col-xl-6 justify-content-center">

				<div class="d-flex justify-content-between justify-content-xl-end products-sort">
					<div class="d-flex">
						<a href="?R=<?=$_GET['R'];?>&I=<?=$_GET['I'];?>&sort=<?=$_GET['sort'];?>&display=block" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
							<i class="icon-sirting_block"></i>
						</a>

						<a href="?R=<?=$_GET['R'];?>&I=<?=$_GET['I'];?>&sort=<?=$_GET['sort'];?>&display=list" class="mr-2 d-none d-lg-flex justify-content-center align-items-center products-sort__button">
							<i class="icon-sirting_line"></i>
						</a>
					</div>

					<?
					$text = 'Цена: По возрастанию';
					if($_GET['sort'] == 'price_d')
						$text = 'Цена: По убыванию';
					if($_GET['sort'] == 'popular')
						$text = 'По популярности';
					?>

					<div class="d-flex dropdown">
						<button class="btn bg-white d-flex justify-content-between align-items-center" href="#" role="a" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="icon-arrow-down-sign-to-navigate-3"></i>
							<span class="text-right"><?=$text;?></span>
						</button>

						<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<a class="dropdown-item" href="?R=<?=$_GET['R'];?>&I=<?=$_GET['I'];?>&sort=price_a&display=<?=$_GET['display'];?>">Цена: По возрастанию</a>
							<a class="dropdown-item" href="?R=<?=$_GET['R'];?>&I=<?=$_GET['I'];?>&sort=price_d&display=<?=$_GET['display'];?>">Цена: По убыванию</a>
							<a class="dropdown-item" href="?R=<?=$_GET['R'];?>&I=<?=$_GET['I'];?>&sort=popular&display=<?=$_GET['display'];?>">По популярности</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?if($_GET['display'] == 'list'){?>
		<div class="row row-cols-2 row-cols-lg-1">
			<?foreach($arResult['ITEMS'] as $item){;?>
				<div class="mb-4 col">
					<div class="card product-card product-line">
						<div class="card-link">
							<div class="image-block">
								<div class="i-box">

									<?
									if($item['PREVIEW_PICTURE'])
									{
										$image = resizeImg($item['PREVIEW_PICTURE'], 195, 158);
									}
									else
										$image = SITE_TEMPLATE_PATH.'/assets/no-image.svg';
									?>

									<a href="<?=$item['DETAIL_PAGE_URL'];?>"><img src="<?=$image?>" alt="<?=$item['NAME'];?>"></a>
								</div>
							</div>

							<div class="px-2 px-lg-3 d-flex justify-content-between like-price">
								<p class="mb-0 like followThisItem">
									<svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
								</p>

								<p class="mb-0 price"><?=ICON_CURRENCY;?> <?=number_format($item['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?></p>
							</div>

							<div class="px-2 px-lg-3 content-block">
								<div class="text-right">
									<a href="<?=$item['DETAIL_PAGE_URL'];?>" class="mb-2 mb-lg-3 title"><?=$item['NAME'];?></a>
									<a class="mb-2 mb-lg-4 category"><?=$item['PREVIEW_TEXT'];?></a>
								</div>

								<div class="border-top py-2 d-flex justify-content-between align-items-center text-nowrap product-line__data-viwe">
									<div class="d-flex">
										<span class="mr-0 mr-lg-2 views"><span><?=$item['SHOW_COUNTER'];?></span> <i class="icon-visibility"></i></span>

										<span class="product-line__like like_f" data-ad_id="<?=$item['ID'];?>">Избранное
                                                    <svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
                                                  </span>
									</div>

									<?
									$strDate = getStringDate($item['DATE_CREATE']);
									?>
									<span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
								</div>
							</div>
						</div>
					</div>
				</div>

			<?}?>

		</div>
		<?}else{?>


		<div class="row row-cols-2 row-cols-lg-4">
			<?foreach($arResult['ITEMS'] as $item){;?>
				<div class="mb-4 col">
					<div class="card product-card">
						<div class="image-block">
							<div class="i-box">
								<?
								if($item['PREVIEW_PICTURE'])
								{
									$image = resizeImg($item['PREVIEW_PICTURE'], 195, 158);
								}
								else
									$image = SITE_TEMPLATE_PATH.'/assets/no-image.svg';
								?>
								<a href="<?=$item['DETAIL_PAGE_URL'];?>"><img src="<?=$image;?>" alt="<?=$item['NAME'];?>"></a>
							</div>
						</div>

						<div class="px-2 px-lg-3 d-flex justify-content-between">
							<p class="mb-0 like followThisItem" data-ad_id="<?=$item['ID'];?>">
								<svg id="iconLike" class="iconLike" viewBox="0 0 612 792"><path d="M562.413,284.393c-9.68,41.044-32.121,78.438-64.831,108.07L329.588,542.345l-165.11-149.843 c-32.771-29.691-55.201-67.076-64.892-108.12c-6.965-29.484-4.103-46.14-4.092-46.249l0.147-0.994 c6.395-72.004,56.382-124.273,118.873-124.273c46.111,0,86.703,28.333,105.965,73.933l9.061,21.477l9.061-21.477 c18.958-44.901,61.694-73.922,108.896-73.922c62.481,0,112.478,52.27,119,125.208C566.517,238.242,569.379,254.908,562.413,284.393z"/></svg>
							</p>

							<p class="mb-0 price"><?=ICON_CURRENCY;?> <?=number_format($item['PROPERTIES']['PRICE']['VALUE'], 0, '.', ' ');?></p>
						</div>

						<div class="px-2 px-lg-3 content-block">
							<div class="text-right">
								<a href="<?=$item['DETAIL_PAGE_URL'];?>" class="mb-2 mb-lg-3 title"><?=$item['NAME'];?></a>
							</div>

							<div class="border-top py-2 py-lg-3 d-flex justify-content-between align-items-center text-nowrap">
								<span class="mr-0 mr-lg-2 views"><span><?=$item['SHOW_COUNTER'];?></span> <i class="icon-visibility"></i></span>
								<?
								$strDate = getStringDate($item['DATE_CREATE']);
								?>
								<span class="date"><?=($strDate['MES']) ? GetMessage($strDate['MES']).', '.$strDate['HOURS'] : $strDate['HOURS'];?></span>
							</div>
						</div>
					</div>
				</div>
			<?}?>
		</div>
		<?}?>

		<?=$arResult['NAV_STRING'];?>
	</div>
<?}else{?>
	<div class="container">
		<div class="mb-5 row d-flex align-items-center">
			<h1 class="h2 mb-4" >ПО ВАШЕМУ ЗАПРОСУ НИЧЕГО НЕ НАЙДЕНО (</h1>
		</div>
	</div>

<?}?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>