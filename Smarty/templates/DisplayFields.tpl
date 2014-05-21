{*<!--

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

-->*}

{assign var="fromlink" value=""}

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
{foreach key=label item=subdata from=$data}
	{if $header eq 'Product Details'}
		<tr>
	{else}
		<tr style="height:25px">
	{/if}
	{foreach key=mainlabel item=maindata from=$subdata}
		{* ed edited *}
			{* ----hiding fields---- *}
			{if is_array($hideFieldsTPL) && $maindata[2][0]|in_array:$hideFieldsTPL}
				{assign var="hidingStatField" value="style='display:none'"}
			{else}
				{assign var="hidingStatField" value=""}
			{/if}
			{* ----disable---- *}
			{if is_array($forcedisable) && $maindata[2][0]|in_array:$forcedisable}
				{assign var="forcedisableStat" value="disabled"}
				{assign var="hidingIMG" value="style='display:none'"}
			{else}
				{assign var="forcedisableStat" value=""}
				{assign var="hidingIMG" value=""}
			{/if}
		{* ed edited end *}
		{include file='EditViewUI.tpl'}
	{/foreach}
   </tr>
{/foreach}
