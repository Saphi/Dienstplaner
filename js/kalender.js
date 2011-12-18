// grundeinstellungen
var A_TKALDEF = {
	'monate' : ['Januar', 'Februar', 'M�rz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
	'wochentage' : ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
	'jahrbl': true, // jahr kann gewechselt werden
	'wochenstart': 1, // erster tag der woche: 0-So or 1-Mo
	'zjahr'  : 70,
	'bilderpfad' : 'bilder/' // pfad f�r bilder
};
// datumsanalyse
function f_tkal_analyse_datum (s_datum) {

	var re_datum = /^\s*(\d{1,2})\.(\d{1,2})\.(\d{2,4})\s*$/;
	if (!re_datum.exec(s_datum))
		return alert ("Falsches Datum: '" + s_datum + "'.\nFormat: TT-MM-JJJJ.")
	var n_tag = Number(RegExp.$1),
		n_monat = Number(RegExp.$2),
		n_jahr = Number(RegExp.$3);

	if (n_jahr < 100)
		n_jahr += (n_jahr < this.a_tpl.zjahr ? 2000 : 1900);
	if (n_monat < 1 || n_monat > 12)
		return alert ("Falsche Monatseingabe: '" + n_monat + "'.\nM�gliche Werte sind 01 - 12.");
	var d_numtage = new Date(n_jahr, n_monat, 0);
	if (n_tag > d_numtage.getDate())
		return alert("Falsche Tageingabe: '" + n_tag + "'.\nM�gliche Werte sind 01 - " + d_numtage.getDate() + ".");

	return new Date (n_jahr, n_monat - 1, n_tag);
}
// datum erstellen
function f_tkal_erstelle_datum (d_datum) {
	return (
		(d_datum.getDate() < 10 ? '0' : '') + d_datum.getDate() + "."
		+ (d_datum.getMonth() < 9 ? '0' : '') + (d_datum.getMonth() + 1) + "."
		+ d_datum.getFullYear()
	);
}

// implementatieren
function tcal (a_cfg, a_tpl) {

	// standardangabe
	if (!a_tpl)
		a_tpl = A_TKALDEF;

	// register
	if (!window.A_TKALS)
		window.A_TKALS = [];
	if (!window.A_TKALSIDX)
		window.A_TKALSIDX = [];

	this.s_id = a_cfg.id ? a_cfg.id : A_TKALS.length;
	window.A_TKALS[this.s_id] = this;
	window.A_TKALSIDX[window.A_TKALSIDX.length] = this;

	// methoden zuweisen
	this.f_zeige = f_tcalZeige;
	this.f_verberge = f_tcalVerberge;
	this.f_toggle = f_tcalToggle;
	this.f_updatum = f_tcalUpdatum;
	this.f_relDatum = f_tcalRelDatum;
	this.f_analyseDatum = f_tkal_analyse_datum;
	this.f_erstelleDatum = f_tkal_erstelle_datum;

	// kalendersymbol erstellen
	this.s_symbolId = 'tcalico_' + this.s_id;
	this.e_symbol = f_getElement(this.s_symbolId);
	if (!this.e_symbol) {
		document.write('<img src="' + a_tpl.bilderpfad + 'kal.gif" id="' + this.s_symbolId + '" onclick="A_TKALS[\'' + this.s_id + '\'].f_toggle()" class="tcalIcon" alt="Kalender �ffnen" />');
		this.e_symbol = f_getElement(this.s_symbolId);
	}
	// parameter speichern
	this.a_cfg = a_cfg;
	this.a_tpl = a_tpl;
}

function f_tcalZeige (d_datum) {

	// eingabefeld ermitteln
	if (!this.a_cfg.controlname)
		throw("TC: control name is not specified");
	if (this.a_cfg.formname) {
		var e_form = document.forms[this.a_cfg.formname];
		if (!e_form)
			throw("TC: form '" + this.a_cfg.formname + "' can not be found");
		this.e_input = e_form.elements[this.a_cfg.controlname];
	}
	else
		this.e_input = f_getElement(this.a_cfg.controlname);

	if (!this.e_input || !this.e_input.tagName || this.e_input.tagName != 'INPUT')
		throw("TC: element '" + this.a_cfg.controlname + "' does not exist in "
			+ (this.a_cfg.formname ? "form '" + this.a_cfg.controlname + "'" : 'this document'));

	// bei Bedarf dynamische HTML-Elemente erstellen
	this.e_div = f_getElement('tcal');
	if (!this.e_div) {
		this.e_div = document.createElement("DIV");
		this.e_div.id = 'tcal';
		document.body.appendChild(this.e_div);
	}
	this.e_schatten = f_getElement('tcalschatten');
	if (!this.e_schatten) {
		this.e_schatten = document.createElement("DIV");
		this.e_schatten.id = 'tcalschatten';
		document.body.appendChild(this.e_schatten);
	}
	this.e_iframe =  f_getElement('tcalIF');
	if (b_ieFix && !this.e_iframe) {
		this.e_iframe = document.createElement("IFRAME");
		this.e_iframe.style.filter = 'alpha(opacity=0)';
		this.e_iframe.id = 'tcalIF';
		this.e_iframe.src = this.a_tpl.bilderpfad + 'pixel.gif';
		document.body.appendChild(this.e_iframe);
	}

	// kalender verbergen
	f_tcalVerbergeAlle();

	// kalender �ffnen
	this.e_symbol = f_getElement(this.s_symbolId);
	if (!this.f_updatum())
		return;

	this.e_div.style.visibility = 'visible';
	this.e_schatten.style.visibility = 'visible';
	if (this.e_iframe)
		this.e_iframe.style.visibility = 'visible';

	// symbol und status �ndern
	this.e_symbol.src = this.a_tpl.bilderpfad + 'x_kal.gif';
	this.e_symbol.title = 'Kalender schliessen';
	this.b_visible = true;
}

function f_tcalVerberge (n_datum) {
	if (n_datum)
		this.e_input.value = this.f_erstelleDatum(new Date(n_datum));

	// keine aktion wenn unsichtbar
	if (!this.b_visible)
		return;

	// Elemente verbergen
	if (this.e_iframe)
		this.e_iframe.style.visibility = 'hidden';
	if (this.e_schatten)
		this.e_schatten.style.visibility = 'hidden';
	this.e_div.style.visibility = 'hidden';

	// symbol und status �ndern
	this.e_symbol = f_getElement(this.s_symbolId);
	this.e_symbol.src = this.a_tpl.bilderpfad + 'kal.gif';
	this.e_symbol.title = 'Kalender �ffnen';
	this.b_visible = false;
}

function f_tcalToggle () {
	return this.b_visible ? this.f_verberge() : this.f_zeige();
}

function f_tcalUpdatum (d_datum) {

	var d_today = this.a_cfg.today ? this.f_analyseDatum(this.a_cfg.today) : f_tcalResetTime(new Date());
	var d_selected = this.e_input.value == ''
		? (this.a_cfg.selected ? this.f_analyseDatum(this.a_cfg.selected) : d_today)
		: this.f_analyseDatum(this.e_input.value);

	// datum zur anzeige ermitteln
	if (!d_datum)
		// standard
		d_datum = d_selected;
	else if (typeof(d_datum) == 'number')
		// von nummer
		d_datum = f_tcalResetTime(new Date(d_datum));
	else if (typeof(d_datum) == 'string')
		// von text
		d_datum = this.f_analyseDatum(d_datum);

	if (!d_datum) return false;

	// datum anzeigen
	var d_erstertag = new Date(d_datum);
	d_erstertag.setDate(1);
	d_erstertag.setDate(1 - (7 + d_erstertag.getDay() - this.a_tpl.wochenstart) % 7);

	var a_class, s_html = '<table class="ctrl"><tbody><tr>'
		+ (this.a_tpl.jahrbl ? '<td' + this.f_relDatum(d_datum, -1, 'y') + ' title="Voriges Jahr"><img src="' + this.a_tpl.bilderpfad + 'voriges_jahr.gif" /></td>' : '')
		+ '<td' + this.f_relDatum(d_datum, -1) + ' title="Voriger Monat"><img src="' + this.a_tpl.bilderpfad + 'voriger_monat.gif" /></td><th>'
		+ this.a_tpl.monate[d_datum.getMonth()] + ' ' + d_datum.getFullYear()
			+ '</th><td' + this.f_relDatum(d_datum, 1) + ' title="N�chster Monat"><img src="' + this.a_tpl.bilderpfad + 'naechster_monat.gif" /></td>'
		+ (this.a_tpl.jahrbl ? '<td' + this.f_relDatum(d_datum, 1, 'y') + ' title="N�chstes Jahr"><img src="' + this.a_tpl.bilderpfad + 'naechstes_jahr.gif" /></td></td>' : '')
		+ '</tr></tbody></table><table><tbody><tr class="wd">';

	// wochtage anzeigen
	for (var i = 0; i < 7; i++)
		s_html += '<th>' + this.a_tpl.wochentage[(this.a_tpl.wochenstart + i) % 7] + '</th>';
	s_html += '</tr>' ;

	// kalendertabelle anzeigen
	var n_datum, n_monat, d_aktuell = new Date(d_erstertag);
	while (d_aktuell.getMonth() == d_datum.getMonth() ||
		d_aktuell.getMonth() == d_erstertag.getMonth()) {

		// Zeilen anzeigen
		s_html +='<tr>';
		for (var n_wtag = 0; n_wtag < 7; n_wtag++) {

			a_class = [];
			n_datum = d_aktuell.getDate();
			n_monat = d_aktuell.getMonth();

			// anderer monat
			if (d_aktuell.getMonth() != d_datum.getMonth())
				a_class[a_class.length] = 'anderermonat';
			// wochenende
			if (d_aktuell.getDay() == 0 || d_aktuell.getDay() == 6)
				a_class[a_class.length] = 'wochenende';
			// heute
			if (d_aktuell.valueOf() == d_today.valueOf())
				a_class[a_class.length] = 'heute';
			// ausgew�hlt
			if (d_aktuell.valueOf() == d_selected.valueOf())
				a_class[a_class.length] = 'ausgewaehlt';

			s_html += '<td onclick="A_TKALS[\'' + this.s_id + '\'].f_verberge(' + d_aktuell.valueOf() + ')"' + (a_class.length ? ' class="' + a_class.join(' ') + '">' : '>') + n_datum + '</td>';
			d_aktuell.setDate(++n_datum);
		}
		// fusszeile anzeigen
		s_html +='</tr>';
	}
	s_html +='</tbody></table>';

	// erneuere HTML
	this.e_div.innerHTML = s_html;

	var n_width  = this.e_div.offsetWidth;
	var n_height = this.e_div.offsetHeight;
	var n_top  = f_holePosition (this.e_symbol, 'Top') - n_height;
	var n_left = f_holePosition (this.e_symbol, 'Left') + this.e_symbol.offsetWidth;
	if (n_left < 0) n_left = 0;

	this.e_div.style.left = n_left + 'px';
	this.e_div.style.top  = n_top + 'px';

	this.e_schatten.style.width = (n_width + 8) + 'px';
	this.e_schatten.style.left = (n_left - 1) + 'px';
	this.e_schatten.style.top = (n_top - 1) + 'px';
	this.e_schatten.innerHTML = b_ieFix
		? '<table><tbody><tr><td rowspan="2" colspan="2" width="6"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td><td width="7" height="7" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + this.a_tpl.bilderpfad + 'schatten_tr.png\', sizingMethod=\'scale\');"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td></tr><tr><td height="' + (n_height - 7) + '" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + this.a_tpl.bilderpfad + 'schatten_mr.png\', sizingMethod=\'scale\');"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td></tr><tr><td width="7" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + this.a_tpl.bilderpfad + 'schatten_bl.png\', sizingMethod=\'scale\');"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td><td style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + this.a_tpl.bilderpfad + 'schatten_bm.png\', sizingMethod=\'scale\');" height="7" align="left"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td><td style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + this.a_tpl.bilderpfad + 'schatten_br.png\', sizingMethod=\'scale\');"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td></tr><tbody></table>'
		: '<table><tbody><tr><td rowspan="2" width="6"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td><td rowspan="2"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td><td width="7" height="7"><img src="' + this.a_tpl.bilderpfad + 'schatten_tr.png"></td></tr><tr><td background="' + this.a_tpl.bilderpfad + 'schatten_mr.png" height="' + (n_height - 7) + '"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td></tr><tr><td><img src="' + this.a_tpl.bilderpfad + 'schatten_bl.png"></td><td background="' + this.a_tpl.bilderpfad + 'schatten_bm.png" height="7" align="left"><img src="' + this.a_tpl.bilderpfad + 'pixel.gif"></td><td><img src="' + this.a_tpl.bilderpfad + 'schatten_br.png"></td></tr><tbody></table>';

	if (this.e_iframe) {
		this.e_iframe.style.left = n_left + 'px';
		this.e_iframe.style.top  = n_top + 'px';
		this.e_iframe.style.width = (n_width + 6) + 'px';
		this.e_iframe.style.height = (n_height + 6) +'px';
	}
	return true;
}

function f_holePosition (e_elemRef, s_coord) {
	var n_pos = 0, n_offset,
		e_elem = e_elemRef;

	while (e_elem) {
		n_offset = e_elem["offset" + s_coord];
		n_pos += n_offset;
		e_elem = e_elem.offsetParent;
	}
	// Browseranpassung
	if (b_ieMac)
		n_pos += parseInt(document.body[s_coord.toLowerCase() + 'Margin']);
	else if (b_safari)
		n_pos -= n_offset;

	e_elem = e_elemRef;
	while (e_elem != document.body) {
		n_offset = e_elem["scroll" + s_coord];
		if (n_offset && e_elem.style.overflow == 'scroll')
			n_pos -= n_offset;
		e_elem = e_elem.parentNode;
	}
	return n_pos;
}

function f_tcalRelDatum (d_datum, d_diff, s_units) {
	var s_units = (s_units == 'y' ? 'FullYear' : 'Month');
	var d_result = new Date(d_datum);
	d_result['set' + s_units](d_datum['get' + s_units]() + d_diff);
	if (d_result.getDate() != d_datum.getDate())
		d_result.setDate(0);
	return ' onclick="A_TKALS[\'' + this.s_id + '\'].f_updatum(' + d_result.valueOf() + ')"';
}

function f_tcalVerbergeAlle () {
	if (!window.A_TKALSIDX) return;
	for (var i = 0; i < window.A_TKALSIDX.length; i++)
		window.A_TKALSIDX[i].f_verberge();
}

function f_tcalResetTime (d_datum) {
	d_datum.setHours(12);
	d_datum.setMinutes(0);
	d_datum.setSeconds(0);
	d_datum.setMilliseconds(0);
	return d_datum;
}

f_getElement = document.all ?
	function (s_id) { return document.all[s_id] } :
	function (s_id) { return document.getElementById(s_id) };

if (document.addEventListener)
	window.addEventListener('scroll', f_tcalVerbergeAlle, false);
if (window.attachEvent)
	window.attachEvent('onscroll', f_tcalVerbergeAlle);

// globale variablen
var s_userAgent = navigator.userAgent.toLowerCase(),
	re_webkit = /WebKit\/(\d+)/i;
var b_mac = s_userAgent.indexOf('mac') != -1,
	b_ie5 = s_userAgent.indexOf('msie 5') != -1,
	b_ie6 = s_userAgent.indexOf('msie 6') != -1 && s_userAgent.indexOf('opera') == -1;
var b_ieFix = b_ie5 || b_ie6,
	b_ieMac  = b_mac && b_ie5,
	b_safari = b_mac && re_webkit.exec(s_userAgent) && Number(RegExp.$1) < 500;