<?
if (!defined("DBPROJ")) header('Location: /', TRUE, 303);
?>

<div class="pure-g" style="text-align:center;">
	<div class="evaluate-box pure-u-2-5">
		<div class="mainform evaluate">
			<div class="box-title" style="background: #519251;">
				<span class="mega-octicon octicon-law"></span> 평가하기
			</div>
			<div class="descript">
				오른쪽 평가자료를 평가해 주세요
			</div>
			<form id="values" method="POST">
				<label>Speed
				<input type="number" name="Speed" min="0" max="100" placeholder="0~100">
				</label><br><br>
				<label>Size
				<input type="number" name="Size" min="0" max="100" placeholder="0~100">
				</label><br><br>
				<label>Ease of Use
				<input type="number" name="Ease-of-Use" min="0" max="100" placeholder="0~100">
				</label><br><br>
				<label>Reliability
				<input type="number" name="Reliability" min="0" max="100" placeholder="0~100">
				</label><br><br>
				<label>Robustness
				<input type="number" name="Robustness 구성" min="0" max="100" placeholder="0~100">
				</label><br><br>
				<label>Portability
				<input type="number" name="Portability" min="0" max="100" placeholder="0~100">
				</label><br><br>
				<label>Contribution
				<input type="number" name="Contribution" min="0" max="1" placeholder="0~1" step="0.01">
				</label><br><br>
			</form>
			<div>
				<a id="do-evaluate" data-func="do-evaluate"
				class="pure-button pure-button-primary submit ajax_load" type="button" name="commit">
					<span class="octicon octicon-checklist"></span> 평가하기
				</a>
			</div>
		</div>
	</div>
	<div class="src-code-box pure-u-2-5">
		<div class="mainform src-code">
			<div class="box-title" style="background: #2c4985;">
				<span class="mega-octicon octicon-file-pdf"></span> 소스코드
			</div>
			<div class="descript">
				평가할 개발자의 소스코드 입니다.
			</div>
			<div>
				<!-- 평가할 소스코드 -->
			</div>
		</div>
	</div>
</div>
<?
?>
