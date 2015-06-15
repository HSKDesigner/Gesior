<?php
if(!defined('INITIALIZED'))
	exit;

$list = 'experience';
if(isset($_REQUEST['list']))
	$list = $_REQUEST['list'];

$page = 0;
if(isset($_REQUEST['page']))
	$page = min(50, $_REQUEST['page']);

$vocation = '';
if(isset($_REQUEST['vocation']))
	$vocation = $_REQUEST['vocation'];

switch($list)
{
	case "fist":
		$id=Highscores::SKILL_FIST;
		$list_name='Fist Fighting';
		break;
	case "club":
		$id=Highscores::SKILL_CLUB;
		$list_name='Club Fighting';
		break;
	case "sword":
		$id=Highscores::SKILL_SWORD;
		$list_name='Sword Fighting';
		break;
	case "axe":
		$id=Highscores::SKILL_AXE;
		$list_name='Axe Fighting';
		break;
	case "distance":
		$id=Highscores::SKILL_DISTANCE;
		$list_name='Distance Fighting';
		break;
	case "shield":
		$id=Highscores::SKILL_SHIELD;
		$list_name='Shielding';
		break;
	case "fishing":
		$id=Highscores::SKILL_FISHING;
		$list_name='Fishing';
		break;
	case "magic":
		$id=Highscores::SKILL__MAGLEVEL;
		$list_name='Magic';
		break;
	default:
		$id=Highscores::SKILL__LEVEL;
		$list_name='Experience';
		break;
}
$world_name = $config['server']['serverName'];

$offset = $page * 100;
$skills = new Highscores($id, 100, $page, $vocation);
$main_content .= '<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100%><TR><TD></TD><TD>';

$main_content .= '<TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 WIDTH=100%></TABLE><div class="TableContainer" style="width:100%;">
                <div class="CaptionContainer">
                <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif)"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif)"></span>
                <span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif)"></span>
                <span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif)"></span>
                <div class="Text" style="font-size:12pt;">Ranking for '.htmlspecialchars($list_name).' on '.htmlspecialchars($world_name).'</div>
<span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif)"></span>
<span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif)"></span>
<span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif)"></span>
<span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif)"></span>
</div>
</div><table class="Table2" cellpadding="0" cellspacing="0">
                
<tbody><tr>
<td>
<div class="InnerTableContainer">
<table width="100%">
<tbody><tr class="LabelH"><td style="text-align:right;width:1%;">#
</td>

<td style="text-align:center;width:5%">Outfit</td>
<td style="text-align:left;width:50%">Name
</td>
<td style="text-align:center;width:10%;">Level

</td>';
if($list == "experience")
	$main_content .= '<td style="text-align:left;width:10%">Experience</td>';
//$main_content .= '</TR><TR>';
$main_content .= '</TR>';
$number_of_rows = 0;
foreach($skills as $skill)
{
	if($list == "magic")
		$value = $skill->getMagLevel();
	elseif($list == "experience")
		$value = $skill->getLevel();
	else
		$value = $skill->getScore();
	$bgcolor = (($number_of_rows++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
	$main_content .= '<tr bgcolor="'.$bgcolor.'"><td style="text-align:right">'.($offset + $number_of_rows).'.</td><TD><div style="position: relative; width: 32px; height: 32px;"><div style="background-image: url(\'' . $config['site']['outfit_images_url'] . '?id=' . $skill->getLookType() . '&addons=' . $skill->getLookAddons() . '&head=' . $skill->getLookHead() . '&body=' . $skill->getLookBody() . '&legs=' . $skill->getLookLegs() . '&feet=' . $skill->getLookFeet() . '\'); position: absolute; width: 64px; height: 80px; background-position: bottom right; background-repeat: no-repeat; right: -10px; bottom: 0px;"></div></div></TD><td><a href="?subtopic=characters&name='.urlencode($skill->getName()).'">'.($skill->getOnline()>0 ? "<font color=\"green\">".htmlspecialchars($skill->getName())."</font>" : "<font color=\"red\">".htmlspecialchars($skill->getName())."</font>").'</a><br><small>'.$skill->getLevel().' '.htmlspecialchars(Website::getVocationName($skill->getVocation())).'</small></td><td><center>'.$value.'</center></td>';
	if($list == "experience")
		$main_content .= '<td style="width:10%">'.$skill->getExperience().'</td>';
	$main_content .= '</tr>';
}
$main_content .= '</tbody></table>
</div>
</td></tr></tbody></table>
</div><TABLE BORDER=0 CELLPADDING=4 CELLSPACING=1 WIDTH=100%></br>';
if($page > 0)
	$main_content .= '<TD WIDTH=100% ALIGN=left VALIGN=bottom><A HREF="?subtopic=highscores&list='.urlencode($list).'&page='.($page - 1).'" CLASS="size_xxs"><nobr>Previous Page</nobr></A></TD>';
if($number_of_rows > 99)
	$main_content .= '<TD WIDTH=100% ALIGN=right VALIGN=bottom><A HREF="?subtopic=highscores&list='.urlencode($list).'&page='.($page + 1).'" CLASS="size_xxs"><nobr>Next Page</nobr></A></TD>';
$main_content .= '</TABLE></TD><TD WIDTH=5%></TD><TD WIDTH=15% VALIGN=top ALIGN=right><div class="TableContainer" style="width:117px;">
				<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
							<span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
							<span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>				
							<div class="Text" style="padding-left:7px;font-size:9pt;">Choose a Skill</div>
							<span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>
							<span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
							<span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
						</div>
					</div><table class="Table3" cellpadding="0" cellspacing="0">
					
					<tbody><tr>		
						<td>		
							<div class="InnerTableContainer">
								<table>
									<tbody><tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%">
														<tbody><tr style="background-color:'.$config['site']['lightborder'].';">
															<td class="LabelV"><A HREF="?subtopic=highscores&list=experience">Experience</a></td>
															
														</tr>
														<tr style="background-color:'.$config['site']['darkborder'].';">
															<td class="LabelV"><A HREF="?subtopic=highscores&list=magic">Magic</a></td>
															
														</tr>
														<tr style="background-color:'.$config['site']['lightborder'].';">
															<td class="LabelV"><A HREF="?subtopic=highscores&list=shield">Shielding</a></td>
																
														</tr>
														<tr style="background-color:'.$config['site']['darkborder'].';">
															<td class="LabelV"><A HREF="?subtopic=highscores&list=distance">Distance</a></td>
															
														</tr>
														<tr style="background-color:'.$config['site']['lightborder'].';">
															<td class="LabelV"><A HREF="?subtopic=highscores&list=club">Club</a></td>
															
														</tr>
														<tr style="background-color:'.$config['site']['darkborder'].';"><td class="LabelV"><A HREF="?subtopic=highscores&list=sword">Sword</a></td></tr>
<tr style="background-color:'.$config['site']['lightborder'].';"><td class="LabelV"><A HREF="?subtopic=highscores&list=axe">Axe</a></td></tr>
<tr style="background-color:'.$config['site']['darkborder'].';"><td class="LabelV"><A HREF="?subtopic=highscores&list=fist">Fist</a></td></tr>
<tr style="background-color:'.$config['site']['lightborder'].';"><td class="LabelV"><A HREF="?subtopic=highscores&list=fishing">Fishing</a></td></tr>

													</tbody></table>
												</div>
											</div>
											<div class="TableShadowContainer">
												<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
													<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
													<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
												</div>
											</div>
										</td>
									</tr>
									
								</tbody></table>
							</div></td></tr></tbody></table>
					</div></br>';
							$main_content .= '<div class="TableContainer" style="width:117px;">
				<div class="CaptionContainer">
						<div class="CaptionInnerContainer"> 
							<span class="CaptionEdgeLeftTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
							<span class="CaptionEdgeRightTop" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
							<span class="CaptionBorderTop" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span> 
							<span class="CaptionVerticalLeft" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>				
							<div class="Text" style="padding-left:0px;padding-right:0px;font-size:8pt;">Choose a Vocation</div>
							<span class="CaptionVerticalRight" style="background-image:url(./layouts/tibiarl/images/content/box-frame-vertical.gif);"></span>
							<span class="CaptionBorderBottom" style="background-image:url(./layouts/tibiarl/images/content/table-headline-border.gif);"></span> 
							<span class="CaptionEdgeLeftBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
							<span class="CaptionEdgeRightBottom" style="background-image:url(./layouts/tibiarl/images/content/box-frame-edge.gif);"></span>
						</div>
					</div><table class="Table3" cellpadding="0" cellspacing="0">
					
					<tbody><tr>		
						<td>		
							<div class="InnerTableContainer">
								<table>
									<tbody><tr>
										<td>
											<div class="TableShadowContainerRightTop">
												<div class="TableShadowRightTop" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rt.gif);"></div>
											</div>
											<div class="TableContentAndRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-rm.gif);">
												<div class="TableContentContainer">
													<table class="TableContent" width="100%">
														<tbody>
<SCRIPT LANGUAGE="JavaScript">
function selecturl(s) {
	var gourl = s.options[s.selectedIndex].value;	window.top.location.href = gourl;
}
</SCRIPT>


<FORM>

<SELECT class="textbox" name="urljump" OnChange="selecturl(this)" style="width:95px;">
<OPTION value="">Select</OPTION>
<option value="?subtopic=highscores&list='.urlencode($list).'">All</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=1">Sorcerer</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=2">Druid</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=3">Paladin</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=4">Knight</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=5">Master Sorcerer</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=6">Elder Druid</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=7">Royal Paladin</option>
<option value="?subtopic=highscores&list='.urlencode($list).'&vocation=8">Elite Knight</option>
</SELECT>
</FORM>

													</tbody></table>
												</div>
											</div>
											<div class="TableShadowContainer">
												<div class="TableBottomShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bm.gif);">
													<div class="TableBottomLeftShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-bl.gif);"></div>
													<div class="TableBottomRightShadow" style="background-image:url(./layouts/tibiarl/images/content/table-shadow-br.gif);"></div>
												</div>
											</div>
										</td>
									</tr>
									
								</tbody></table>
							</div></td></tr></tbody></table>
					</div>';
							$main_content .= '</TD><TD></TD></TR></TABLE>';