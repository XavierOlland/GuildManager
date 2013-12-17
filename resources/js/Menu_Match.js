/*  Guild Manager has been designed to help Guild Wars 2 (and other MMOs) guilds to organize themselves for PvP battles.
    Copyright (C) 2013  Xavier Olland

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Affero General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>. */


//Définition des variables
var default_world_id = 2103;

var world_names;
var matches;
var match_details;

//Récupéraiton du nom du serveur
var getWorldNameById = function (id) {
	for (var i in world_names) {
		if (id == world_names[i].id) {
			return world_names[i].name;
		}
	}
};
//Stockage des information du match
var current_matchup = {
	red : {
		id : "",
		label: "",
	},
	blue : {
		id : "",
		label: "",
	},
	green : {
		id : "",
		label: "",
	},
};

//Récupéraiton des noms des mondes
var main = function () {
	$.getJSON("https://api.guildwars2.com/v1/world_names.json?lang=fr", worlds_callback);
};
//Récupération des matches en cours
var worlds_callback = function (data) {
	world_names = data;
	$.getJSON("https://api.guildwars2.com/v1/wvw/matches.json", matches_callback);
};
//Exploitation des matchs pour isoler le match du serveur
var matches_callback = function (data) {
	matches = data.wvw_matches;
	var match_id;
	for (var i in matches) {
		var match = matches[i];
		if ((match.red_world_id == default_world_id) || (match.green_world_id == default_world_id) || (match.blue_world_id == default_world_id)) {
			match_id = match.wvw_match_id;
			current_matchup.red.id = match.red_world_id;
			current_matchup.red.label = getWorldNameById(match.red_world_id);
			if(current_matchup.red.label.match(/]/g)) { current_matchup.red.label = current_matchup.red.label.substring(0,current_matchup.red.label.length - 5)};
			current_matchup.green.id = match.green_world_id;
			current_matchup.green.label = getWorldNameById(match.green_world_id);
			if(current_matchup.green.label.match(/]/g)) { current_matchup.green.label = current_matchup.green.label.substring(0,current_matchup.green.label.length - 5)};
			current_matchup.blue.id = match.blue_world_id;
			current_matchup.blue.label = getWorldNameById(match.blue_world_id);
			if(current_matchup.blue.label.match(/]/g)) { current_matchup.blue.label = current_matchup.blue.label.substring(0,current_matchup.blue.label.length - 5)};

			break;
		}
	}
	
//Récupération des informations du match en cours
	$.getJSON("https://api.guildwars2.com/v1/wvw/match_details.json?match_id="+match_id, match_details_callback);
};

var match_details_callback = function (data) {
	match_details = data;
	
	var red_score = match_details.scores[0];
	var blue_score = match_details.scores[1];
	var green_score = match_details.scores[2];    
	var max = Math.max(red_score, blue_score, green_score);
	
//Modification de l'affichage
  $('#red_score .label').css({"font-family":"guildText","color":"#000000","font-size":"16px"});
		if (current_matchup.red.id == default_world_id) {$('#red_score .label').css("font-weight","bold")};
	$('#red_score .label').html('<p>' + current_matchup.red.label + '</p><p style=\"text-align:right\">' + red_score.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' pts</p>');
	$( "#red_score .bar" ).progressbar({ value: red_score, max: max});
	$('#red_score .bar .ui-widget-header').css('background', '#A80000');
	$('#red_score .bar' ).height(15);
	
    $('#blue_score .label').css({"font-family":"guildText","color":"#000000","font-size":"16px"});
		if (current_matchup.blue.id == default_world_id) {$('#blue_score .label').css("font-weight","bold")};
	$('#blue_score .label').html('<p>' + current_matchup.blue.label + '</p><p style=\"text-align:right\">' + blue_score.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' pts</p>');
	$( "#blue_score .bar" ).progressbar({ value: blue_score, max: max});
	$('#blue_score .bar .ui-widget-header').css('background', '#0033FF');
	$('#blue_score .bar' ).height(15);

  $('#green_score .label').css({"font-family":"guildText","color":"#0000000","font-size":"16px"});
		if (current_matchup.green.id == default_world_id) {$('#green_score .label').css("font-weight","bold")};
	$('#green_score .label').html('<p>' + current_matchup.green.label + '</p><p style=\"text-align:right\">' + green_score.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ") + ' pts</p>');
	$('#green_score .bar').progressbar({ value: green_score, max: max});
	$('#green_score .bar .ui-widget-header').css('background', '#006600');
	$('#green_score .bar').height(15);

}


$(document).ready(function () {
    main();
});