DROP DATABASE IF EXISTS geeler;
CREATE DATABASE IF NOT EXISTS geeler;
USE geeler;

CREATE TABLE users(
  ID INT UNSIGNED NOT NULL PRIMARY KEY,
  username VARCHAR(25) NOT NULL UNIQUE,
  email VARCHAR(300) NOT NULL UNIQUE,
  joined TIMESTAMP(1) NOT NULL DEFAULT CURRENT_TIMESTAMP(1),
  INDEX index_users_username(username),
  INDEX index_users_email(email)
);
CREATE TABLE passwords(
  userFK INT UNSIGNED NOT NULL,
  password VARCHAR(256) NOT NULL,
  FOREIGN KEY (userFK) REFERENCES users(ID)
);
CREATE TABLE lang(
  ID VARCHAR(100) NOT NULL UNIQUE PRIMARY KEY,
  content TEXT NOT NULL,
  type VARCHAR(20) NOT NULL
);

INSERT INTO users VALUES (0, "admin", "email", DEFAULT);
INSERT INTO passwords VALUES(0, "$2y$10$pBKGMHH67Ql3taIlDwzriOycP9KBYfPrlSISjYAalVoVwGz5azAZa");

INSERT INTO lang VALUES
("meta.desc", "My name is Noah Geeler, I'm an apprentice as an aplication developer in Zürich."),
("title.home", "Startseite - geeler.net"),
("home.navbar.title", "Navigation"),
("home.navbar.home", "Start"),
("home.navbar.about", "Über mich"),
("home.navbar.projects", "Projekte"),
("home.navbar.contact", "Kontakt"),
("home.navbar.donate", "Spenden"),
("home.home.title", "Noah Geeler"),
("home.home.subtitle1", "Lernender Informatiker Applikationsentwicklung"),
("home.home.subtitle2", "Hobby Programmierer"),
("home.home.subtitle3", "Layer 8"),
("user.login", "Einloggen"),
("user.register", "Registrieren"),
("home.about.title", "Über mich"),
("home.about.general.title", "Allgemein"),
("home.about.general.text", "Hallo, mein Name ist Noah Geeler. Ich bin 16 Jahre alt und mache eine Lehre als Informatiker im Fachbereich Applikationsentwicklung in Zürich. Meine Lieblingstiere Katzen, jegendlicher Grösse und Eichhörnchen, da ich sehr fasziniert war von ihren Spring-Fähigkeiten als ich noch klein war.<br> Meine Stärken sind PHP und vielleicht noch ein wenig CSS, da ich bereits sehr viel mit denen gearbeitet habe und fast nie auf etwas anderes fokussiert war. Meine Schwäche ist Französisch, weil ich die Sprache nicht mag.<br> Wenn ein Familienmitglied oder ein Freund mich beschreiben, sagen sie, dass ich immer pünklich, clever und ab und zu ein nerd bin."),
("home.about.hobby.title", "Mein Hobby"),
("home.about.hobby.text", "Ich arbeite hauptsächlich an Privaten Projekte, wie diese Webseite hier.<br> Ich habe mein grösstes Projekt auch als so eines gemacht. Du kannst <a href=""#nevah5com"">hier</a> mehr darüber lernen.<br> Neben dem Programmieren oder Webseiten erstellen, spiele ich auch Valorant, ein taktisches, ""first-person shooter"" Videospiel, mit meinen Freunden. Das Ziel des Spieles ist es die Bombe zu platzieren/entschärfen. Man Spielt immer in einem 5er Team. Ich würde sagen das wichtigste ist die Kommunikation. Wenn man die Teamleaders Anweisungen missachtet, wird man sehr wahrscheinlich sterben. In den meisten Fällen sehe ich mich als dieser, da ich sehr oft an verschiedene Taktiken und Verbesserungsmöglichkeiten für unser Team denke."),
("home.about.motivation.title", "Motivation"),
("home.about.motivation.text", "Wenn ich weiss, was ich an einem Projekt mitarbeite und ich am Ende sagen kann oder erkennen kann, was ich gemacht habe, motiviert und hilft mir das sehr. Meine Motivation besteht darin ein Projekt zu beenden, dies treibt mich vorwärts, bis ich das Endprodukt schwach vor meinen Augen schimmern sehe. Mein Ziel ist es immer etwas neues und interessantes zu lernen. Auch möchte ich an meine Limits von etwas kommen, etwas schaffen, daran scheitern und vielmals neu versuchen. Diese Dinge sind für mich sehr wichtig, und ich schätze dies sehr. Das sind einige Gründe, warum ich diesen Job gewählt habe."),
("home.about.whyme.title", "Warum mich?"),
("home.about.whyme.text", "Vielleicht hast du jetzt bereits ein Bild von mir gemacht, aber warum solltest du genau mich wählen. Lass es mir dich erzählen. Wenn ich ein Tier nehmen müsste, das mich am meisten beschreibt, würde ich eine Katze wählen, da sie ihre Energie am effizientesten nützt, nämlich für das jagen. Sie sind auch immer in die Zukunft am schauen, wie ich.<br> Wenn du jetzt einen jungen, produktiven und interessanten Mann, der immer weiss was er tut, einer der immer in die Zukunft denkt und immer für sein Team schaut, bin ich genau der richtige!"),
("home.project.title", "Projekte"),
("home.contact.title", "Kontakt"),
("home.contact.email.emoji", "✉️ Email"),
("home.contact.email", "Email"),
("home.contact.phone.emoji", "📞 Telefon"),
("home.contact.phone", "Telefon"),
("home.contact.message", "Wenn du versuchst mich mit der überstehenden Email zu erreichen, antworte ich wahrschinlich nicht direkt. Ich empfehle das Formular unten zu benutzen, das automatisch eine Email in meine private Inbox weiterleitet."),
("home.contact.form.title", "Schick mir eine Nachricht"),
("home.contact.form.email", "Deine Email"),
("home.contact.form.message", "Deine Nachricht"),
("home.contact.form.acceptdb", "Du bist dir bewusst, dass ich deine Email Adresse mit Nachricht und deiner IP Adresse in meiner Datenbank speichere. Ich werde diese nur für Private zwecke nutzen."),
("home.contact.form.acceptsecurity", "Du hast die <a href=""/privacy/"" target=""_blank"">Datenschutzbedingunen</a> gelesen und akzeptierst diese."),
("home.contact.form.submit", "Senden"),
("home.donate.title", "Spenden um mich zu unterstützen"),
("home.donate.or", "oder"),
("title.login", "Einloggen - geeler.net"),
("login.title", "Einloggen"),
("login.email", "Email"),
("login.password", "Passwort"),
("login.submit", "Einloggen"),
("login.error.noemail", "Bitte gib eine Email Adresse an!"),
("login.error.notexists", "Dieser Benutzer existiert nicht!"),
("login.error.nopassword", "Bitte gib ein Passwort an!"),
("login.error.passwordwrong", "Das Passwort stimmt nicht überein!"),
("footer.stuff.title", "Diverses"),
("footer.stuff.tos", "Nutzungsbedingungen"),
("footer.stuff.privacy", "Datenschutz"),
("footer.stuff.guidelines", "Richtlinien"),
("footer.stuff.acknownledgements", "Dankeschön"),
("footer.stuff.licence", "Lizenz"),
