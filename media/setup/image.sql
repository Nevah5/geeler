DROP DATABASE IF EXISTS geeler;
CREATE DATABASE IF NOT EXISTS geeler;
USE geeler;

DROP TABLE IF EXISTS contact;
DROP TABLE IF EXISTS cookie;
DROP TABLE IF EXISTS 2FA;
DROP TABLE IF EXISTS ads;
DROP TABLE IF EXISTS verify;
DROP TABLE IF EXISTS lang;
DROP TABLE IF EXISTS passwords;
DROP TABLE IF EXISTS users;

CREATE TABLE users(
  ID VARCHAR(32) NOT NULL PRIMARY KEY,
  username VARCHAR(25) NOT NULL UNIQUE,
  email VARCHAR(300) NOT NULL UNIQUE,
  joined TIMESTAMP(1) NOT NULL DEFAULT CURRENT_TIMESTAMP(1),
  2FA TINYINT(1) DEFAULT NULL,
  INDEX index_users_username(username),
  INDEX index_users_email(email)
);
CREATE TABLE passwords(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userFK VARCHAR(32) NOT NULL,
  password VARCHAR(256) NOT NULL,
  FOREIGN KEY (userFK) REFERENCES users(ID)
);
CREATE TABLE lang(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  lang CHAR(2) NOT NULL,
  type VARCHAR(20) NOT NULL,
  title VARCHAR(100) NOT NULL,
  content TEXT NOT NULL,
  INDEX index_lang_id(ID)
);
CREATE TABLE verify(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userFK VARCHAR(32) NOT NULL,
  token CHAR(128) NOT NULL,
  generated TIMESTAMP(1) NOT NULL DEFAULT CURRENT_TIMESTAMP(1),
  FOREIGN KEY (userFK) REFERENCES users(ID)
);
CREATE TABLE ads(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userFK VARCHAR(32) NOT NULL,
  accepted TIMESTAMP(1) NOT NULL DEFAULT CURRENT_TIMESTAMP(1)
);
CREATE TABLE 2FA(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userFK VARCHAR(32) NOT NULL,
  code VARCHAR(6) NOT NULL,
  valid DATETIME(1) NOT NULL,
  FOREIGN KEY (userFK) REFERENCES users(ID)
);
CREATE TABLE cookie(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  userFK VARCHAR(32) NOT NULL,
  token VARCHAR(16) NOT NULL,
  secret VARCHAR(16) NOT NULL,
  FOREIGN KEY (userFK) REFERENCES users(ID)
);
CREATE TABLE contact(
  ID INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(300) NOT NULL,
  message TEXT NOT NULL,
  IP VARCHAR(15) NOT NULL,
  sent TIMESTAMP(1) DEFAULT CURRENT_TIMESTAMP(1)
);

INSERT INTO users VALUES (0, "admin", "admin@geeler.net", DEFAULT, 1);
INSERT INTO passwords VALUES(NULL, 0, "$2y$10$pBKGMHH67Ql3taIlDwzriOycP9KBYfPrlSISjYAalVoVwGz5azAZa");
INSERT INTO lang (lang, type, title, content) VALUES
("DE", "home", "meta.desc", "Hallo, ich bin Noah Geeler und mache eine Ausbildung als Informatiker."),
("DE", "home", "title", "Startseite - geeler.net"),
("DE", "home", "navbar.title", "Navigation"),
("DE", "home", "navbar.home", "Start"),
("DE", "home", "navbar.about", "Über mich"),
("DE", "home", "navbar.projects", "Projekte"),
("DE", "home", "navbar.contact", "Kontakt"),
("DE", "home", "navbar.donate", "Spenden"),
("DE", "home", "home.title", "Noah Geeler"),
("DE", "home", "home.subtitle1", "Lernender Informatiker Applikationsentwicklung"),
("DE", "home", "home.subtitle2", "Hobby Programmierer"),
("DE", "home", "home.subtitle3", "Layer 8"),
("DE", "home", "user.login", "Einloggen"),
("DE", "home", "user.register", "Registrieren"),
("DE", "home", "about.title", "Über mich"),
("DE", "home", "about.general.title", "Allgemein"),
("DE", "home", "about.general.text", "Hallo, mein Name ist Noah Geeler. Ich bin 16 Jahre alt und mache eine Lehre als Informatiker im Fachbereich Applikationsentwicklung in Zürich. Meine Lieblingstiere Katzen, jegendlicher Grösse und Eichhörnchen, da ich sehr fasziniert war von ihren Spring-Fähigkeiten als ich noch klein war.<br> Meine Stärken sind PHP und vielleicht noch ein wenig CSS, da ich bereits sehr viel mit denen gearbeitet habe und fast nie auf etwas anderes fokussiert war. Meine Schwäche ist Französisch, weil ich die Sprache nicht mag.<br> Wenn ein Familienmitglied oder ein Freund mich beschreiben, sagen sie, dass ich immer pünklich, clever und ab und zu ein nerd bin."),
("DE", "home", "about.hobby.title", "Mein Hobby"),
("DE", "home", "about.hobby.text", "Ich arbeite hauptsächlich an Privaten Projekte, wie diese Webseite hier.<br> Ich habe mein grösstes Projekt auch als so eines gemacht. Du kannst <a href=""#nevah5com"">hier</a> mehr darüber lernen.<br> Neben dem Programmieren oder Webseiten erstellen, spiele ich auch Valorant, ein taktisches, ""first-person shooter"" Videospiel, mit meinen Freunden. Das Ziel des Spieles ist es die Bombe zu platzieren/entschärfen. Man Spielt immer in einem 5er Team. Ich würde sagen das wichtigste ist die Kommunikation. Wenn man die Teamleaders Anweisungen missachtet, wird man sehr wahrscheinlich sterben. In den meisten Fällen sehe ich mich als dieser, da ich sehr oft an verschiedene Taktiken und Verbesserungsmöglichkeiten für unser Team denke."),
("DE", "home", "about.motivation.title", "Motivation"),
("DE", "home", "about.motivation.text", "Wenn ich weiss, was ich an einem Projekt mitarbeite und ich am Ende sagen kann oder erkennen kann, was ich gemacht habe, motiviert und hilft mir das sehr. Meine Motivation besteht darin ein Projekt zu beenden, dies treibt mich vorwärts, bis ich das Endprodukt schwach vor meinen Augen schimmern sehe. Mein Ziel ist es immer etwas neues und interessantes zu lernen. Auch möchte ich an meine Limits von etwas kommen, etwas schaffen, daran scheitern und vielmals neu versuchen. Diese Dinge sind für mich sehr wichtig, und ich schätze dies sehr. Das sind einige Gründe, warum ich diesen Job gewählt habe."),
("DE", "home", "about.whyme.title", "Warum mich?"),
("DE", "home", "about.whyme.text", "Vielleicht hast du jetzt bereits ein Bild von mir gemacht, aber warum solltest du genau mich wählen. Lass es mir dich erzählen. Wenn ich ein Tier nehmen müsste, das mich am meisten beschreibt, würde ich eine Katze wählen, da sie ihre Energie am effizientesten nützt, nämlich für das jagen. Sie sind auch immer in die Zukunft am schauen, wie ich.<br> Wenn du jetzt einen jungen, produktiven und interessanten Mann, der immer weiss was er tut, einer der immer in die Zukunft denkt und immer für sein Team schaut, bin ich genau der richtige!"),
("DE", "home", "project.title", "Projekte"),
("DE", "home", "contact.title", "Kontakt"),
("DE", "home", "contact.email.emoji", "✉️ Email"),
("DE", "home", "contact.email", "Email"),
("DE", "home", "contact.phone.emoji", "📞 Telefon"),
("DE", "home", "contact.phone", "Telefon"),
("DE", "home", "contact.message", "Wenn du versuchst mich mit der überstehenden Email zu erreichen, antworte ich wahrschinlich nicht direkt. Ich empfehle das Formular unten zu benutzen, das automatisch eine Email in meine private Inbox weiterleitet."),
("DE", "home", "contact.message.empty", "Bitte gib eine Nachricht an."),
("DE", "home", "contact.form.title", "Schick mir eine Nachricht"),
("DE", "home", "contact.form.email", "Deine Email"),
("DE", "home", "contact.form.message", "Deine Nachricht"),
("DE", "home", "contact.form.message.short", "Bitte schreibe mindestens 75 Zeichen als Nachricht."),
("DE", "home", "contact.form.acceptdb", "Du bist dir bewusst, dass ich deine Email Adresse mit Nachricht und deiner IP Adresse in meiner Datenbank speichere. Ich werde diese nur für Private zwecke nutzen."),
("DE", "home", "contact.form.acceptdb.required", "Du musst es akzeptieren."),
("DE", "home", "contact.form.acceptsecurity", "Du hast die <a href=""/privacy/"" target=""_blank"">Datenschutzbedingunen</a> gelesen und akzeptierst diese."),
("DE", "home", "contact.form.acceptsecurity.required", "Du musst die Datenschutzbedingunen akzeptieren."),
("DE", "home", "contact.form.submit", "Senden"),
("DE", "home", "contact.form.success", "Deine Nachricht wurde erfolgreich versendet!"),
("DE", "home", "contact.form.spam", "Bitte hör auf Nachrichten zu spammen. Versuch es später erneut."),
("DE", "home", "donate.title", "Spenden um mich zu unterstützen"),
("DE", "home", "donate.or", "oder"),
("DE", "login", "title", "Einloggen - geeler.net"),
("DE", "login", "section.title", "Einloggen"),
("DE", "login", "email", "Email"),
("DE", "login", "password", "Passwort"),
("DE", "login", "submit", "Einloggen"),
("DE", "login", "error.noemail", "Bitte gib eine Email Adresse an!"),
("DE", "login", "error.notexists", "Ein Benutzer mit dieser Email Adresse existiert nicht!"),
("DE", "login", "error.nopassword", "Bitte gib ein Passwort an!"),
("DE", "login", "error.passwordwrong", "Das Passwort stimmt nicht überein!"),
("DE", "login", "user.login", "Einloggen"),
("DE", "login", "user.register", "Registrieren"),
("DE", "login", "password.forgot", "Passwort vergessen?"),
("DE", "login", "stayloggedin", "Eingeloggt bleiben"),
("DE", "login", "accountregister", "Du hast noch kein Account? Erstelle einen <a href=""/register/"">hier</a>!"),
("DE", "login", "account.verify.first", "Bitte verifiziere deinen Account zuerst."),
("DE", "login", "verification.error.title", "Verifizierungsfehler:"),
("DE", "login", "verification.error.tokennotset", "Du musst einen Token angeben."),
("DE", "login", "verification.error.tokeninvalid", "Der angegebene Token ist nicht gültig."),
("DE", "login", "verification.success", "Du hast deinen Account erfolgreich verifiziert."),
("DE", "login", "title.2fa", "2FA - geeler.net"),
("DE", "login", "section.title.2fa", "2FA"),
("DE", "login", "2fa", "Code"),
("DE", "login", "2fa.resend", "Code erneut senden"),
("DE", "login", "submit.2fa", "Validieren"),
("DE", "login", "2fa.message.title", "Zwei Faktor Authentifizierung"),
("DE", "login", "2fa.message.resent", "Der Code wurde erfolgreich erneut versendet. Bitte schau in deine Mails."),
("DE", "login", "2fa.message.sent", "Der Code wurde erfolgreich versendet. Bitte schau in deine Mails."),
("DE", "login", "2fa.message.wait", "Bitte warte bevor du den Code erneut versendest."),
("DE", "login", "2fa.error.code.invalid", "Dieser Code ist nicht gültig."),
("DE", "login", "2fa.sentto", "Der Code wurde an $email gesendet."),
("DE", "register", "title", "Registrieren - geeler.net"),
("DE", "register", "section.title", "Registrieren"),
("DE", "register", "email", "Email Adresse"),
("DE", "register", "repeatemail", "Email Adresse wiederholen"),
("DE", "register", "username", "Benutzername"),
("DE", "register", "password", "Passwort"),
("DE", "register", "repeatpassword", "Passwort wiederholen"),
("DE", "register", "submit", "Registrieren"),
("DE", "register", "error.noemail", "Bitte gib eine Email Adresse an."),
("DE", "register", "error.emailexists", "Ein Account mit dieser Email Adresse existiert bereits."),
("DE", "register", "error.emailinvalid", "Diese Email Adresse ist nicht gültig."),
("DE", "register", "error.emailmatch", "Die Email Adressen stimmen nicht überein."),
("DE", "register", "error.repeatemailempty", "Bitte wiederhole die Email Adresse."),
("DE", "register", "error.usernameinvalid", "Dieser Benutzername ist nicht gültig. [3-32 Länge, keine Leer- und spezielle Zeichen]"),
("DE", "register", "error.userexists", "Dieser Benutzername existiert bereits."),
("DE", "register", "error.emptyusername", "Bitte gib einen Benutzernamen an."),
("DE", "register", "error.emptypassword", "Bitte gib ein Passwort an."),
("DE", "register", "error.passwordnotmatch", "Die Passwörter stimmen nicht überein!"),
("DE", "register", "user.login", "Einloggen"),
("DE", "register", "user.register", "Registrieren"),
("DE", "register", "accept.email", "Du möchtest über Email Benachrichtigungen und Updates erhalten."),
("DE", "register", "accountlogin", "Du hast bereits ein Account erstellt? Logge dich <a href=""/register/"">hier</a> ein!"),
("DE", "register", "required", "Benötigt"),
("DE", "register_success", "title", "Erfolg! - geeler.net"),
("DE", "register_success", "section.title", "Registrieren"),
("DE", "register_success", "success", "Erfolg!"),
("DE", "register_success", "info", "Bitte verifiziere deine Email Adresse, mit der gesendeten Email adresse an <?= $email ?>, bevor du dich <a href=""/login/"">einloggen</a> kannst."),
("DE", "401", "errormessage", "Unautorisiert!"),
("DE", "403", "errormessage", "Verboten!"),
("DE", "404", "errormessage", "Seite nicht gefunden!"),
("DE", "404", "didyoumean", "Meintest du"),
("DE", "410", "errormessage", "Verschwunden!"),
("DE", "footer", "stuff.title", "Diverses"),
("DE", "footer", "stuff.tos", "Nutzungsbedingungen"),
("DE", "footer", "stuff.privacy", "Datenschutz"),
("DE", "footer", "stuff.guidelines", "Richtlinien"),
("DE", "footer", "stuff.acknownledgements", "Dankeschön"),
("DE", "footer", "stuff.licence", "Lizenz");

INSERT INTO lang (lang, type, title, content) VALUES
("EN", "home", "meta.desc", "My name is Noah Geeler, I'm an apprentice as an aplication developer in Zürich."),
("EN", "home", "title", "Home - geeler.net"),
("EN", "home", "navbar.title", "Navigation"),
("EN", "home", "navbar.home", "Home"),
("EN", "home", "navbar.about", "About"),
("EN", "home", "navbar.projects", "Projects"),
("EN", "home", "navbar.contact", "Contact"),
("EN", "home", "navbar.donate", "Donate"),
("EN", "home", "home.title", "Noah Geeler"),
("EN", "home", "home.subtitle1", "Apprentice Application Developer"),
("EN", "home", "home.subtitle2", "Hobby Programmer"),
("EN", "home", "home.subtitle3", "Layer 8"),
("EN", "home", "user.login", "Login"),
("EN", "home", "user.register", "Register"),
("EN", "home", "about.title", "About me"),
("EN", "home", "about.general.title", "General"),
("EN", "home", "about.general.text", "Hi, I'm Noah Geeler. I'm 16 years old and doing an apprenticeship as an application developer in Zurich (Switzerland). I really like cats of any size and squirrels, because of their jumping skills, they're both my favourite animals.<br> My strengths are PHP and maybe CSS, because I've worked with them for a longer time and haven't focused on anything else. My weakness is French, because I really don't like the language.<br> When family members and friends describe me, they say that I'm always on time, clever and sometimes a nerd. "),
("EN", "home", "about.hobby.title", "My hobby"),
("EN", "home", "about.hobby.text", "I mainly work on private projects, such as this website.<br> I've also done my biggest project as one. You can learn more about it <a href=""#nevah5com"">here</a>.<br> Apart from programming or making websites, I also play Valorant, a tactical shooter game, with my friends. The aim of the game is it to plant a bomb/defuse the bomb. You always play in a team of 5. I would say that the most important thing of this game is the communication. If you ignore your team leader's commands, you will probably die quickly and loose the round. In most cases, I see myself as this leader, because I think about special tactics to execute or optimizing our teamplay. "),
("EN", "home", "about.motivation.title", "Motivation"),
("EN", "home", "about.motivation.text", "When I know, what I'm contributing to the project and at the end can say or see what I have done, then I'm really motivated to help and support it. My motivation to finish a project pushes me forwards until I almost see the finished product shimmering in front of my eyes. My goals are always to learn something new and interesting. Also, I want to get on the limits of something, trying, succeeding, and failing. Those are the most important things, that I really appreciate, that's also partially why I have chosen this job. "),
("EN", "home", "about.whyme.title", "Why me?"),
("EN", "home", "about.whyme.text", "So maybe you have already taken a picture of me, but why should you pick exactly me? Well, let me tell you. If I'd have to pick an animal that mostly describes me with its characteristics, I will say a cat, because it uses its energy the most efficient, in this case for hunting. They're also always looking forwards into the future, like me.<br> If you now want a young, productive, and interested man, that always knows what his tasks are, thinking in advance and caring about his team, then I'm the perfect candidate. "),
("EN", "home", "project.title", "Projects"),
("EN", "home", "contact.title", "Contact"),
("EN", "home", "contact.email.emoji", "✉️ Email"),
("EN", "home", "contact.email", "Email"),
("EN", "home", "contact.phone.emoji", "📞 Phone"),
("EN", "home", "contact.phone", "Phone"),
("EN", "home", "contact.message", "If you try to reach me on the specified email above, I might not respond quickly. I'd recommend using the form below, that automatically sends an email, with your message to my private inbox."),
("EN", "home", "contact.message.empty", "Please specify a message."),
("EN", "home", "contact.form.title", "Send me a message"),
("EN", "home", "contact.form.email", "Your Email"),
("EN", "home", "contact.form.message", "Your Message"),
("EN", "home", "contact.form.message.short", "Please write at least 75 characters."),
("EN", "home", "contact.form.acceptdb", "You are aware that I store your message with your given email adress and your IP Adress in my database. I will use them for private or checking purposes only."),
("EN", "home", "contact.form.acceptdb.required", "You have to accept."),
("EN", "home", "contact.form.acceptsecurity", "You have read the <a href=""/privacy/"" target=""_blank"">Privacy</a> agreement and accept it."),
("EN", "home", "contact.form.acceptsecurity.required", "You have to accept the Privacyagreement."),
("EN", "home", "contact.form.submit", "Submit"),
("EN", "home", "contact.form.success", "Your message was sent successfully!"),
("EN", "home", "contact.form.spam", "Please stop spamming messages. Try again later."),
("EN", "home", "donate.title", "Donate to support me"),
("EN", "home", "donate.or", "or"),
("EN", "login", "title", "Login - geeler.net"),
("EN", "login", "section.title", "Login"),
("EN", "login", "email", "Email"),
("EN", "login", "password", "Password"),
("EN", "login", "submit", "Login"),
("EN", "login", "error.noemail", "Please specify an email adress."),
("EN", "login", "error.notexists", "The user with the specified email adress does not exist!"),
("EN", "login", "error.nopassword", "Please specify a password!"),
("EN", "login", "error.passwordwrong", "The password doesn't match!"),
("EN", "login", "user.login", "Login"),
("EN", "login", "user.register", "Register"),
("EN", "login", "password.forgot", "Forgot Password?"),
("EN", "login", "stayloggedin", "Stay logged in"),
("EN", "login", "accountregister", "You don't have an account yet? Create one <a href=""/register/"">here</a>!"),
("EN", "login", "account.verify.first", "Please verify your account first."),
("EN", "login", "verification.error.title", "Verification Error:"),
("EN", "login", "verification.error.tokennotset", "You have to specify a Token."),
("EN", "login", "verification.error.tokeninvalid", "The specified Token is invalid."),
("EN", "login", "verification.success", "You successfully verified your account."),
("EN", "login", "title.2fa", "2FA - geeler.net"),
("EN", "login", "section.title.2fa", "2FA"),
("EN", "login", "2fa", "Code"),
("EN", "login", "2fa.resend", "Resend Code"),
("EN", "login", "submit.2fa", "Validate"),
("EN", "login", "2fa.message.title", "Two Factor Authentication:"),
("EN", "login", "2fa.message.resent", "The Code was successfully resent. Please check your inbox."),
("EN", "login", "2fa.message.sent", "The Code was successfully sent. Please check your inbox."),
("EN", "login", "2fa.message.wait", "Please wait a bit before resending."),
("EN", "login", "2fa.error.code.invalid", "This code is not valid."),
("EN", "login", "2fa.sentto", "Code was sent to: $email"),
("EN", "register", "title", "Register - geeler.net"),
("EN", "register", "section.title", "Register"),
("EN", "register", "email", "Email"),
("EN", "register", "repeatemail", "Repeat Email"),
("EN", "register", "username", "Username"),
("EN", "register", "password", "Password"),
("EN", "register", "repeatpassword", "Repeat Password"),
("EN", "register", "submit", "Register"),
("EN", "register", "error.noemail", "Please specify an email adress."),
("EN", "register", "error.emailexists", "An account was already registered with this email adress!"),
("EN", "register", "error.emailinvalid", "This email adress is not valid!"),
("EN", "register", "error.emailmatch", "The email adresses dont match!"),
("EN", "register", "error.repeatemailempty", "Please repeat the email adress."),
("EN", "register", "error.usernameinvalid", "This username is not valid. [3-32 characters, no whitespaces and special characters]"),
("EN", "register", "error.userexists", "This username already exists."),
("EN", "register", "error.emptyusername", "Please specify a username."),
("EN", "register", "error.emptypassword", "Please specify a password."),
("EN", "register", "error.passwordnotmatch", "The passwords dont match!"),
("EN", "register", "user.login", "Login"),
("EN", "register", "user.register", "Register"),
("EN", "register", "accept.email", "You want to get updated with the newest informations per email."),
("EN", "register", "accountlogin", "You already have an account? Login <a href=""/register/"">here</a>!"),
("EN", "register", "required", "Required"),
("EN", "register_success", "title", "Success! - geeler.net"),
("EN", "register_success", "section.title", "Register"),
("EN", "register_success", "success", "Success!"),
("EN", "register_success", "info", "Please verify your email adress, with the sent email to <?= $email ?>, before you can <a href=""/login/"">sign in</a>."),
("EN", "401", "errormessage", "Unauthorized!"),
("EN", "403", "errormessage", "Forbidden!"),
("EN", "404", "errormessage", "Site not found!"),
("EN", "404", "didyoumean", "Did you mean"),
("EN", "410", "errormessage", "Gone!"),
("EN", "footer", "stuff.title", "Stuff"),
("EN", "footer", "stuff.tos", "Terms of service"),
("EN", "footer", "stuff.privacy", "Privacy"),
("EN", "footer", "stuff.guidelines", "Guidelines"),
("EN", "footer", "stuff.acknownledgements", "Acknownledgements"),
("EN", "footer", "stuff.licence", "Licence");
