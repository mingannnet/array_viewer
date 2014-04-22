<?php
/**
 * json_viewer_parse
 * recursion function to expand elements
 * 
 * @param array $ar
 * @param int $dep
 * @access public
 * @return void
 */

function json_viewer_parse($ar,$dep){
	foreach($ar as $index => $val){
		if(is_array($val)){
			if(!count($val)){
				echo '<div class="is-empty-array" data-index="'.HTML($index,FALSE).'"><span class="index">'.$index.'</span> =&gt; array()</div>'."\n";
			}
			else{
				echo '<div class="is-array" data-index="'.HTML($index,FALSE).'"><span class="index array">'.$index.'</span> &nbsp; <span class="folder">-</span> =&gt; <div class="array-box">'."\n";
				json_viewer_parse($val, $dep+1);
				echo '</div></div>';
			}
		}
		else{
			$g=strtolower(gettype($val));
			switch($g){
				case 'boolean':
					echo '<div class="is-boolean" data-index="'.HTML($index,FALSE).'"><span class="index">'.$index.'</span> ('.$g.') =&gt; <span>'.($val?'TRUE':'FALSE').'</span></div>'."\n";
					break;
				case 'double':case 'float':case 'integer':
					echo '<div class="is-number" data-index="'.HTML($index,FALSE).'"><span class="index">'.$index.'</span> ('.$g.') =&gt; <span>'.$val.'</span></div>'."\n";
					break;
				case 'resource':case 'object':
					echo '<div class="is-resource" data-index="'.HTML($index,FALSE).'"><span class="index">'.$index.'</span> ('.$g.') =&gt; <span>'.$val.'</span></div>'."\n";
					break;
				case 'NULL':
					echo '<div class="is-null" data-index="'.HTML($index,FALSE).'"><span class="index">'.$index.'</span> ('.$g.') =&gt; <span>NULL</span></div>'."\n";
					break;
				case 'string':
					echo '<div class="is-string" data-index="'.HTML($index,FALSE).'"><span class="index">'.$index.'</span> ('.$g.') =&gt; <span>&quot;'.$val.'&quot;</span></div>'."\n";
					break;
				default:
					echo '<div class="is-unknown" data-index="'.HTML($index,FALSE).'"><span class="index">'.$index.'</span> ('.$g.') =&gt; <span>'.$val.'</span></div>'."\n";
					break;

			}
		}
	}
}

/**
 * json_viewer 
 * expand array elements on HTML/CSS3
 * 
 * @param array $ar 
 * @param int $dep option
 * @access public
 * @return void
 */
function json_viewer($ar,$dep=0){
?>
<style type="text/css" media="screen">
div {font-size:12px;}
.is-empty-array {border:1px dashed #999;margin-bottom:2px;}	
.is-array .array-box {border:1px solid #ccc;border-right-style:solid;padding-left:1em;margin-bottom:2px;}
.array-hover {background-color:#ff9;}
.index {cursor:pointer;}
.is-boolean {color:#00f;}
.is-number {color:#f00;}
.is-resource {color:#0f0;}
.is-null {color:#666;}
.is-string {color:#009;}
.is-unknown {color:#aa0;}
.array-hover > .array-box > [class^=is] > span.index {font-weight:bold;color:#090;}
.array-hover > span.index {color:#c0c;font-weight:bold;}
.folder {padding-left:0.5em;padding-right:0.5em;}
.folder:before {content:"(";}
.folder:after {content:")";}
.folder:hover {background-color:#f00;color:#ff0;}
#info {position:fixed;left:5px;bottom:0;min-height:2.5em;width:90%;background:#ff0;border:1px solid #009;line-height:1.2em;}
</style>
<?php
	json_viewer_parse($ar,$dep);
?>
	<div id="info">
		<div>PATH: <span id="path"></span></div>
		<div>CHILDREN: <span id="children"></span></div>
	</div>
<script type="text/javascript" src="http://mac.localhost/tools/jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.index').click(function(){
			var $obj=$(this);
			var path=[];
			var children=[];
			$obj.parents().each(function(){
				var $o=$(this);
				if($o.hasClass('array-box') || $o.is('body, html')){
				}
				else{
					path.unshift($o.data('index'));
				}
			});
			if($obj.hasClass('array')){
				$obj.nextAll().filter('.array-box').children().each(function(){
					var $o=$(this);
					children.push($o.data('index'));
				});
				$('#children').html(children.join(', '));
			}
			else{
				$('#children').html('');
			}
			$obj.parent().toggleClass('array-hover');
			$('#path').html(path.join(' / '));
		});
		$('.folder').click(function(){
			var $obj=$(this);
			var closed=$obj.data('closed');
			if(closed){
				$obj.nextAll().filter('.array-box').css({"display":"block"});
				$obj.html('-');
				$obj.data('closed',0);
			}
			else{
				$obj.nextAll().filter('.array-box').css({"display":"none"});
				$obj.html('+');
				$obj.data('closed',1);
			}

		});
		/**
		$('.array-box').mouseover(function(event){
			event.stopPropagation();
			$(this).addClass('array-hover');
		});
		$('.array-box').mouseout(function(event){
			event.stopPropagation();
			$(this).removeClass('array-hover');
		});
		**/
	});
</script>
<?php
}

