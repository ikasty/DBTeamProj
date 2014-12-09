<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);

?>
<div class="pure-g" style="text-align:center; min-height: 100px;">
	<div class="pure-u-1-1">
		<div class="mainform" style="padding: 0px;"><div class="pure-menu pure-menu-open pure-menu-horizontal"><ul>
			<li class="menu-item">
				<a class="ajax_load" data-link="search/test" data-args="selector:#search-form">
					<span class="mega-octicon octicon-person"></span> 개발자 검색
				</a>
			</li>
			<li class="menu-item">
				<a class="ajax_load" data-link="search/company" data-args="selector:#search-form">
					<span class="mega-octicon octicon-organization"></span> 회사 검색
				</a>
			</li>
			<li class="menu-item">
				<a class="ajax_load" data-link="search/test" data-args="selector:#search-form">
					
				</a>
			</li>
		</ul></div></div>
	</div>
	<div class="pure-u-1-1">
		<div id="search-form">
			<div class="mainform" style="min-height: 300px; text-align: left;">
			상단의 메뉴를 선택해서 검색 결과를 확인하세요!
			</div>
		</div>
	</div>
</div>
