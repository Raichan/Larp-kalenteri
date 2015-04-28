<?php

// includes/head.php

$head_title = "LARP.fi Tapahtumakalenteri";

// includes/header.php

$header_title = "Tapahtumakalenteri";
$admin_title = "(Hallintapaneeli)";

// includes/navigation.php

$nav_calendar = "Kalenteri";
$nav_list = "Tapahtumalista";
$nav_search = "Etsi tapahtumia";
$nav_create = "Luo tapahtuma";
$nav_modify = "Muokkaa tapahtumaa";
$nav_help = "Ohjeet";
$nav_admin = "Ylläpito";

// includes/calendar.php

$cal_mon = "MA";
$cal_tue = "TI";
$cal_wed = "KE";
$cal_thu = "TO";
$cal_fri = "PE";
$cal_sat = "LA";
$cal_sun = "SU";

// includes/monthNavigator.php

$button_today = "Tänään";
$button_prev = "Edellinen";
$button_next = "Seuraava";

// includes/upcomingEvents.php

$upcoming = "Tulevia tapahtumia";

// listView.php

$noevents = "Kalenterissa ei ole tapahtumia.";
$listview = "Tapahtumalista";
$ambiguous = "Ajankohdaltaan epämääräiset";

// event.php

$notfound = "Jotain meni pieleen eikä tapahtumaa löytynyt.";

// includes/checkFormErrors.php

$err_name = " Nimi on pakollinen";
$err_startdate = "Aloituspäivämäärä on pakollinen";
$err_date = "Virheellinen päivämäärä";
$err_bothdates = "Anna molemmat päivämäärät";
$err_location = " Sijainti on pakollinen";
$err_icon = " Virheellinen kuvan URL";
$err_cost = " Virheellinen hinta";
$err_desc = " Kuvaus on pakollinen";
$err_emailreq = " Järjestäjän sähköpostiosoite on pakollinen";
$err_emailinv = " Virheellinen sähköpostiosoite";
$err_url = " Virheellinen URL";

// includes/eventForm.php

$text_mandatory = "*-merkityt kentät ovat pakollisia.";
$label_name = "Tapahtuman nimi *";
$label_type = "Tapahtuman tyyppi";
$type_larps = "Larpit";
$type_cons = "Conit ja miitit";
$type_workshops = "Kurssit ja työpajat";
$type_other = "Muut";
$label_dates = "Päivämäärä(t) *";
$text_dates = 'Ylempi vaihtoehto on tarkoitettu päivämäärille. Ilmoita vain pakolliset päivät. (Jos tapahtumasi on lauantaina, mutta paikalle saa saapua perjantaina ja lähteä sunnuntaina, merkitse vain lauantai.) Jos tapahtumasi kestää vain yhden päivän, jätä jälkimmäinen kenttä tyhjäksi. Käytä päivämäärävalitsinta tai kirjoita päivämäärät muodossa pp/kk/vvvv. Jos ajankohtaa ei ole vielä päätetty, käytä alempaa kenttää "Kevät 2016"- tai "joskus ensi vuonna"-tyylisiä vaihtoehtoja varten.';
$label_signup = "Ilmoittautumisaika";
$label_locationmandatory = "Sijainti *";
$text_location = "Valikkoa käytetään tapahtumien hakemiseen ja tekstikenttä näytetään tapahtuman tiedoissa.";
$location_south = "Etelä-Suomi";
$location_southwest = "Lounais-Suomi";
$location_west = "Länsi- ja Sisä-Suomi";
$location_east = "Itä-Suomi";
$location_north = "Pohjois-Suomi";
$location_lapland = "Lappi";
$location_abroad = "Ulkomailla";
$label_icon = "Tapahtumakuva";
$text_icon = "Haluamasi kuvan URL. Suositeltu koko 100x100px.";
$label_genre = "Genre";
$genre_fantasy = "Fantasia";
$genre_scifi = "Sci-fi";
$genre_cyberpunk = "Cyberpunk";
$genre_steampunk = "Steampunk";
$genre_postapo = "Post-apokalyptinen";
$genre_historical = "Historiallinen";
$genre_thriller = "Jännitys";
$genre_horror = "Kauhu";
$genre_reality = "Realismi";
$genre_city = "Kaupunkipeli";
$genre_newweird = "Uuskumma";
$genre_action = "Toiminta";
$genre_drama = "Draama";
$genre_humor = "Huumori";
$label_cost = "Osallistumismaksu";
$text_cost = "Vain yksittäiset numerot (esim. 10) ja välit (esim. 20-25) hyväksytään.";
$label_agelimit = "Ikäraja";
$label_beginnerfriendliness = "Aloittelijaystävällinen";
$label_eventfull = "Tapahtuma on täynnä";
$label_invitationonly = "Kutsupeli";
$label_languagefree = "Kielivapaa tapahtuma";
$label_storydesc = "Tarinallinen kuvaus";
$text_storydesc = "Fiilistelyä, pari replaa tai muuta tarinallista fluffia. Maksimipituus 1000 merkkiä.";
$label_infodesc = "Infokuvaus *";
$text_infodesc = "Se oikeasti tärkeä informaatio. Maksimipituus 3000 merkkiä.";
$label_orgname = "Järjestäjän nimi";
$label_orgemail = "Järjestäjän sähköpostiosoite *";
$label_link1 = "Verkkosivu 1";
$label_link2 = "Verkkosivu 2";
$label_illusion = "Luo Illusion-tapahtuma";
$text_illusion = "Tapahtuma ilmoitetaan myös Forge & Illusionin tapahtumakalenteriin (<a href=\"http://www.forgeandillusion.net/illusion/\">www.forgeandillusion.net/illusion</a>)";
$daterequired_illusion = "Illusion tapahtumilla täytyy olla päivämäärä. Voit luoda Illusion-tapahtuman myöhemmin muokkamalla tapahtumaa";
$button_submit = "Lähetä";

// includes/eventInfo.php

$button_signupopen = "Ilmoittautuminen auki";
$button_beginnerfriendly = "Aloittelijaystävällinen";
$button_eventfull = "Täynnä";
$button_invitationonly = "Kutsupeli";
$button_languagefree = "Kielivapaa";
$info_signup = "Ilmoittautuminen: ";
$info_cost = "Osallistumismaksu: ";
$info_agelimit = "Ikäraja: ";

// searchEvent.php
// many of the missing fields are located under includes/eventForm.php

$title_search = "Etsi tapahtumia";
$label_freesearch = "Vapaa sanahaku";
$type_allevents = "Kaikki tapahtumat";
$label_date = "Tapahtumat aikavälillä";
$label_location = "Sijainti";
$location_any = "Kaikki";
$genre_all = "Rasti kaikki";
$label_maxcost = "Maksimihinta";
$label_signupopen = "Vain tapahtumat, joiden ilmoittautuminen on auki";
$label_beginnerfriendly = "Vain aloittelijaystävälliset tapahtumat";
$label_pastevents = "Myös menneet tapahtumat";
$button_search = "Etsi";

// searchResults.php

$title_searchresults = "Hakutulokset";

// createEvent.php

$title_createevent = "Luo uusi tapahtuma";

// createSuccess.php

$title_createsuccess = "Tapahtuma lähetetty onnistuneesti";
$text_createsuccess = "Kiitos!<br>
                        Tapahtumasi on nyt tallennettu odottamaan ylläpidon hyväksyntää. Hyväksymisen jälkeen saat sähköpostilla salasanan tapahtuman muokkaamista varten.";

// modifyPassword.php

$err_pass1 = "Virheellinen salasana.";
$err_pass2 = "Syötä salasana.";
$enterpassword = "Syötä tapahtuman salasana";
$button_find = "Hae tapahtuma";

// modifyEvent.php

$modify_title = "Muokkaa tapahtumaa";
$modify_delete = "Poista tapahtuma";
$modify_deleteconfirm = "Poista tapahtuma?";
$modify_deletetext = "Olet poistamassa tapahtuman. Sitä ei voi palauttaa.";
$modify_cancel = "Peruuta";

// modifySuccess.php

$title_modifysuccess = "Tapahtumaa muokattu onnistuneesti";
$text_modifysuccess = "Kiitos!<br>
                        Muutoksesi on nyt tallennettu odottamaan ylläpidon hyväksyntää. Voit silti käyttää samaa salasanaa mahdollisia myöhempiä muokkauksia varten.";
	
// deleteSuccess.php

$title_deletesuccess = "Tapahtuma poistettu";
$text_deletesuccess = "Tapahtumasi poistettiin onnistuneesti.";
	
// includes/emails.php

$admin_subject = 'Tapahtuma larp-kalenterissa';
$admin_msg = 'Larp-kalenterissa on uusi tai muokattu tapahtuma, 
	joka vaatii tarkistusta.
	
	Kirjaudu sisään nähdäksesi tapahtuman:
	http://beta.larp.fi/login.php';

$approved_subject = 'Tapahtumasi larp-kalenterissa';
$approved_msg1 = 'Tapahtumasi larp-kalenterissa (tai siihen tehdyt muokkaukset): ';
$approved_msg2 = '
	on juuri hyväksytty.';
$approved_msg3 = '
		
		Ylläpidon kommentit: 
		';
$approved_msg4 = '
	
	Voit nyt katsella tapahtumaasi kalenterissa:
	http://beta.larp.fi/
	
	Salasanasi tapahtuman muokkaukseen on: ';
$approved_msg5 = '
	
	Lähetä sähköpostia osoitteeseen larp.kalenteri@gmail.com jos sinulla on kysymyksiä.';
$denied_subject = 'Tapahtumasi larp-kalenterissa';
$denied_msg1 = 'Tapahtumasi larp-kalenterissa (tai siihen tehdyt muokkaukset: ';
$denied_msg2 = '
	on hylätty seuraavin ylläpidon kommentein:
	';
$denied_msg3 = '
	
	Lähetä sähköpostia osoitteeseen larp.kalenteri@gmail.com jos sinulla on kysymyksiä.';

// loginForm.php

$login_title = "Kirjaudu sisään";
$err_login1 = "Virheellinen kirjautuminen.";
$err_login2 = "Kirjaudu antamalla käyttäjätunnus ja salasana.";
$err_login3 = "Jotain unohtui. Kirjaudu antamalla käyttäjätunnus ja salasana.";	
$label_username = "Käyttäjätunnus";
$label_password = "Salasana";
$button_login = "Kirjaudu";
	
// includes/footer.php

$text_footer = 'Bugeja? Kysymyksiä? Kehitysideoita? Anna palautetta <a href="https://docs.google.com/forms/d/1KjfuzsegKHCLh_10gBNYS7lqkTmwDsWwVgyiqhfO8M8/viewform">täällä</a>.';

// admin/accountManagement.php

$accman_title = "Käyttäjätilien hallinta";

// admin/eventsApproval.php

$evapp_title = "Tapahtumien hyväksyminen";
$evapp_text1 = "Olet hyväksymässä tapahtuman";
$evapp_text2 = "Vahvista hyväksyntä ja lisää tarvittaessa kommentti.";
$btn_approve = "Hyväksy";
$btn_deny = "Hylkää";
$btn_back = "Takaisin";
$evdeny_text1 = "Olet hylkäämässä tapahtuman";
$evdeny_text2 = "Vahvista hylkäys ja lisää tarvittaessa kommentti.";
$admincomments = "Kommentit:";
$dontsend = "Älä lähetä hylkäyksestä sähköpostia";

// admin/includes/adminsForm.php

$addadmin = "Lisää uusi ylläpitäjä";
$admin_msg0 = "Uusi käyttäjä lisätty onnistuneesti.";
$admin_msg1 = "* Kaikki kentät ovat pakollisia.";
$admin_msg2 = "* Käyttäjätunnus on jo olemassa. Valitse toinen.";
$admin_msg3 = "* Annetut salasanat eivät täsmää.";
$admin_msg33 = "* Salasanan on oltava vähintään 5 merkkiä pitkä.";
$admin_msg4 = "* Tapahtui virhe. Yritä myöhemmin uudelleen.";
$admin_name = "Nimi";
$admin_surname = "Sukunimi";
$admin_email = "Email";
$admin_username = "Käyttäjäntunnus";
$admin_pass = "Salasana";
$admin_confirmpass = "Vahvista salasana";
$admin_add = "Lisää";

// admin/includes/adminsFormDelete.php

$admin_deletetitle = "Poista käyttäjätili:";
$admin_delete = "Poista";

// admin/includes/adminsFormModify.php

$admin_modifytitle = "Muokkaa salasanaa käyttäjätilillä:";
$admin_currentpass = "Nykyinen salasana";
$admin_newpass = "Uusi salasana";
$admin_confirmnewpass = "Vahvista uusi salasana";
$admin_modify = "Muokkaa";

// admin/includes/adminsTable.php

$admin_deletesuccess = "Ylläpitäjän käyttäjätili poistettiin onnistuneesti.";
$admin_passnomatch = "* Annetut salasanat eivät täsmää. Yritä uudelleen.";
$admin_shortpass = "* Salasanan on oltava vähintään 5 merkkiä pitkä.";
$admin_passmodsuccess = "Salasana vaihdettu onnistuneesti.";
$admin_error = "* Tapahtui virhe. Tarkista annetut salasanat ja yritä uudestaan.";
$admin_action = "Toiminto";

// admin/includes/eventsTable.php

$event_approved = "Tapahtuma hyväksyttiin onnistuneesti.";
$event_denied = "Tapahtuma hylättiin onnistuneesti.";
$event_error = "Tapahtui virhe. Yritä myöhemmin uudelleen.";
$event_name = "Tapahtuman nimi";
$event_type = "Tapahtuman tyyppi";
$event_start = "Alkamispäivä";
$event_end = "Päättymispäivä";
$event_location = "Sijainti";
$event_genre = "Genre";
$event_cost = "Hinta";
$event_agelimit = "Ikäraja";
$event_beginners = "Aloittelijat";
$event_more = "Lisäinfoa";
$event_action = "Toiminto";
$event_none = "There are no events for approval.";

// help.php

$title_help = "Larp-kalenterin käyttöohjeet";

$main_help = '<p>Larp-kalenterista löydät liveroolipelejä sekä muita niitä sivuavia tapahtumia. Tapahtumia voi tarkastella joko kalenterinäkymässä tai vanhasta larp-kalenterista tuttuna listana, ja lisäksi niitä voi hakea mm. sijainnin, ajankohdan, pelimaksun ja ikärajan perusteella. Tapahtumia voi myös jakaa sosiaalisessa mediassa. Oman pelisi voit ilmoittaa kalenteriin lomakkeen avulla, ja luotuja tapahtumia voi myös muokata jälkeenpäin.</p>
<hr>
<h4>Kuka ja mitä larp-kalenteriin voi ilmoittaa?</h4>
<p>Larp-kalenterin päätarkoitukset ovat seuraavat:<br>
1. Apu pelaajille: Mistä löytäisin ensimmäisen larppini? Millaisia Potter-pelejä tänä vuonna on tulossa? Mihin peleihin on ilmoittautuminen auki juuri nyt?<br>
2. Apu pelinjohtajille: Onko suunnittelemalleni viikonlopulle tulossa jo jokin iso peli? Onko samankaltaisia pelejä pidetty viime aikoina?<br>
3. Suomen larp-skenen dokumentointi: Millaisia pelejä järjestettiin viisi vuotta sitten? Millaisia scifipelejä viime aikoina on pidetty? Kuka sen yhden mahtavan pelin järjestikään?</p>
<p>Näin ollen larp-kalenteriin voi ilmoittaa kuka tahansa ja millaisen larpin tahansa. Haluamme kalenteriin kaikki mahdolliset larpit, joiden kohderyhmään kuuluu suomalaisia. Tämä siis kattaa kaiken pienistä aloittelevan pelinjohdon peleistä suuriin fantasiaeepoksiin. Vaikka pelisi olisi kutsupeli tai täynnä, ilmoita se silti kalenteriin - näin kerrot muille pelinjohtajille pelisi ajankohdasta ja näin vältät mahdollisesti ikäviä päällekkäisyyksiä tai voit mahdollisesti saada kiinnostuneita varapelaajia. Voit myös vapaasti ilmoittaa kalenteriin muiden pitämiä pelejä, kunhan teet sen pelinjohdon suostumuksella.</p>
<p>Varsinaisten larppien lisäksi kalenteriin voi ilmoittaa muitakin aihepiiriin liittyviä tapahtumia, kuten coneja, miittejä, kursseja ja työpajoja. Myös esimerkiksi historialliset tanssit ja boffaus, jotka kuitenkin jakavat jonkin verran harrastajakuntaa larppauksen kanssa, ovat tervetulleita. Jos et ole varma, sopiiko tapahtumasi kalenteriin, ota yhteyttä!</p>
<hr>
<h4>Tapahtuman ilmoittaminen kalenteriin</h4>
<p>Ilmoittaaksesi tapahtuman täytä lomake Luo tapahtuma -linkistä. Pakollisia kohtia ovat vain tapahtuman nimi, ajankohta, sijainti, tapahtuman kuvaus ja järjestäjän sähköpostiosoite. Muutamia ohjeita tapahtuman ilmoittamiseen:<br>
- Jos et ole vielä varma tapahtumasi tarkasta ajankohdasta, voit käyttää alempaa päivämääräkenttää, joka hyväksyy tekstimuotoiset vastaukset kuten "vuonna 2016" tai "ensi keväänä". Huomaathan tosin, että tällaiset tapahtumat eivät näy haussa, jos haetaan ajankohdan perusteella.<br>
- Sijaintia merkitessäsi huomaathan, että aluejako, jota hakutoiminto käyttää, on tehty Suomen aluehallinnon mukaan (<a href="http://fi.wikipedia.org/wiki/Aluehallintovirasto">lisätietoa</a>) paremman virallisen aluejaon puutteessa.<br>
- Voit myös halutessasi asettaa pelillesi logon tai muun 100x100px-kokoisen kuvan. Ethän käytä materiaalia jonka käyttämiseen sinulla ei ole lupaa.<br>
- Genrejä voi valita yhden tai useamman tai jättää kokonaan valitsematta.<br>
- Suosittelemme merkitsemään pelisi aloittelijaystävälliseksi, ellei ole jotain erityistä syytä, miksi pelisi ei aloittelijoille sovi.<br>
</p>
<p>Lähetettyäsi tapahtumalomakkeen tapahtuma siirtyy ylläpidolle hyväksyttäväksi. Kun tapahtumasi on hyväksytty, saat sähköpostilla salasanan, jota voit käyttää muokataksesi tapahtumaa jälkeenpäin.</p>
<hr>
<h4>Kalenteritiimi</h4>
<p>Kysymyksiä, kommentteja ja palautetta voi lähettää kalenterin ylläpidolle osoitteeseen<br>
larp.kalenteri@gmail.com</p>
<p>Kalenterin kehittivät Laura Sirola, Slavek Dittrich ja Pham Tien Hoang Aalto-yliopiston web-palvelukurssin projektityönä keväällä 2014.</p>';

$search_disclaimer = "Hakutoiminto on vielä työn alla.";
$date_placeholder = "01/01/2015";
$datetext_placeholder = "joskus ensi vuonna";
?>