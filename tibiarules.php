<?php
if(!defined('INITIALIZED'))
	exit;

$list = $SQL->query('SELECT ' . $SQL->fieldName('name') . ', ' . $SQL->fieldName('id') . ', ' . $SQL->fieldName('group_id') . ' FROM ' . $SQL->tableName('players') . ' WHERE ' . $SQL->fieldName('group_id') . ' IN (' . implode(',', $config['site']['groups_support']) . ') ORDER BY ' . $SQL->fieldName('group_id') . ' DESC');


$main_content .= '
The website www.tibia.com and the associated online game Tibia are operated by CipSoft GmbH, Germany.
</br></br>
<table width="100%" border="0" cellspacing="1" cellpadding="4">
<tbody><tr><td bgcolor="'.$config['site']['vdarkborder'].'" align="center" class="white"><b>Contact Information</b></td></tr>
<tr><td bgcolor="'.$config['site']['darkborder'].'"><table border="0" cellpadding="8">
<tbody><tr><td valign="top">Address:</td><td>CipSoft GmbH<br>Pr&#252;feninger Stra&#223;e 20<br>93049 Regensburg<br>Germany</td></tr>
<tr><td>Support Email:</td><td><a href="mailto:">support@tibia.com</a></td></tr>
<tr><td>Company Website:</td><td><a href="http://www.cipsoft.com">www.cipsoft.com</a></td></tr>
<tr><td>Managing Directors:</td><td>Ulrich Schlott and Stephan Vogler</td></tr>
<tr><td valign="top">Legal Information:</td><td>based in Regensburg<br>registered at Amtsgericht Regensburg, HRB 8295<br>Ust-IdNr.: DE 216262082</td></tr>
</tbody></table></td></tr>
</tbody></table></br></br>';
$main_content .= '<table width="100%" border="0" cellspacing="1" cellpadding="4">
<tbody><tr><td bgcolor="'.$config['site']['vdarkborder'].'" align="center" class="white"><b>Copyright</b></td></tr>
<tr><td bgcolor="'.$config['site']['darkborder'].'"><table border="0" cellpadding="8"><tbody><tr><td>
<b>Tibia</b><sup>&#174;</sup> - a massively multiplayer online role-playing game.<br>
Copyright &#169; 1996-2015 CipSoft GmbH. All rights reserved.<br>
Tibia is a registered trademark of CipSoft GmbH.
</td></tr></tbody></table></td></tr>
</tbody></table></br></br>';
$main_content .= '<table width="100%" border="0" cellspacing="1" cellpadding="4">
<tbody><tr><td bgcolor="'.$config['site']['vdarkborder'].'" align="center" class="white"><b>Disclaimer</b></td></tr>
<tr><td bgcolor="'.$config['site']['darkborder'].'"><table border="0" cellpadding="8"><tbody><tr><td>
CipSoft GmbH disclaims all warranties for the up-to-dateness, correctness,
completeness or quality of the information presented on this website.
CipSoft GmbH is not liable for any lost profits or special, incidental
or consequential damages arising out of the use or not-use of the presented
information. CipSoft GmbH reserves the right to supplement, change or
delete parts of the website or the whole website, or even to close the
service temporarily or finally.
</td></tr><tr><td>
The following of our websites contain links to other pages on the internet:
tibia.com, tibia.net, tibia.org as well as all connected
subdomains. We would like to expressly emphasise the fact that CipSoft GmbH
has no influence whatsoever on the design or the content of any of the
websites to which these links refer. For this reason CipSoft GmbH cannot
take responsibility for the up-to-dateness, correctness, completeness or
general quality of the information supplied by these websites. Also,
Cipsoft GmbH expressly disassociates itself from any content presented on
said websites. This declaration applies to any link to external websites to
be found on one or more of CipSoft\'s websites, as well as to any kind of
content these external websites may contain.
</td></tr></tbody></table></td></tr>
</tbody></table></br></br>';
$bgcolor = (($i++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
$main_content .= '<table width="100%" border="0" cellspacing="1" cellpadding="4">
      <tbody><tr><td bgcolor="'.$config['site']['vdarkborder'].'" class="white" colspan="3"><b>CipSoft Members</b></td></tr>
      <tr bgcolor="'.$config['site']['darkborder'].'"><td width="100%"><b>Name</b></td><td><b>Group</b></td><td>&nbsp;</td></tr>';

foreach($list as $i => $supporter)
{
	if(!Player::isPlayerOnline($supporter['id']))
		$player_list_status = '<font color="red">Offline</font>';
	else
		$player_list_status = '<font color="green">Online</font>';
	$bgcolor = (($i++ % 2 == 1) ?  $config['site']['darkborder'] : $config['site']['lightborder']);
	$main_content .= '<tr bgcolor="'.$bgcolor.'"><td>'.htmlspecialchars($supporter['name']).'</td><td><nobr>' . htmlspecialchars(Website::getGroupName($supporter['group_id'])) . '<nobr></td><td><a href="?subtopic=characters&name='.urlencode($supporter['name']).'"><img src="'.$layout_name.'/images/buttons/sbutton_view.gif" alt="'.htmlspecialchars($supporter['name']).'"></a></td></tr>';
}

$main_content .= '</td></tr>  </tbody></table>';
