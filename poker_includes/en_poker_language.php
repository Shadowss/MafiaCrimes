<?
// All Page Headings
//-----------------------------------------------------------
  define('HOME', 'Welcome To '.TITLE);
  define('LOGIN', 'Login');
  define('CREATE', 'Create Player');
  define('LOBBY', 'Game Lobby');
  define('RANKINGS', 'Player Rankings');
  define('MY_PLAYER', 'My Player');
  define('RULES', 'Poker Rules');
  define('FAQ', 'Frequently Asked Questions');
  define('ADMIN', 'Admin');
  define('LOGOUT', 'Log Out');
  define('SITOUT', 'Sit Out Page');
  define('POKER_TABLE', 'Poker table');

// Main Menu
//-----------------------------------------------------------
  define('MENU_HOME', 'Home');
  define('MENU_LOGIN', 'Player Login');
  define('MENU_CREATE', 'Create Player');
  define('MENU_LOBBY', 'Game Lobby');
  define('MENU_RANKINGS', 'Player Rankings');
  define('MENU_MYPLAYER', 'My Player');
  define('MENU_RULES', 'Poker Rules');
  define('MENU_FAQ', 'FAQ');
  define('MENU_ADMIN', 'Admin');
  define('MENU_LOGOUT', 'Log Out');

// Table Types & Poker Page
//-----------------------------------------------------------
  define('SITNGO', 'Sit \'n Go');
  define('TOURNAMENT', 'Tournament');
  define('DEALER_INFO', 'DEALER INFORMATION');
  define('TABLEPOT', 'TABLEPOT:');
  define('BUTTON_LEAVE', 'LEAVE TABLE');
  define('BUTTON_SEND', 'Send');

// Top 6 players mod
//-----------------------------------------------------------
  define('PLACE_POSI_1', 'st');
  define('PLACE_POSI_2', 'nd');
  define('PLACE_POSI_3', 'rd');
  define('PLACE_POSI', 'th');
  define('PLACE', 'Place');

// Login Page
//-----------------------------------------------------------
  define('BOX_LOGIN', 'Player Login');
  define('LOGIN_USER', 'Player Name:');
  define('LOGIN_PWD', 'Password:');
  define('BUTTON_LOGIN', 'Login');
  define('LOGIN_NEW_PLAYER', 'Click here to create a new player');
  define('LOGIN_MSG_APPROVAL', 'Account pending approval');
  define('LOGIN_MSG_BANNED', 'This account has been banned!');
  define('LOGIN_MSG_INVALID', 'Invalid Login!');

// Sitout Page
//-----------------------------------------------------------
  define('SITOUT_TIMER', 'Sit Out Timer');

// Create Player Page
//-----------------------------------------------------------
  define('BOX_CREATE_NEW_PLAYER', 'Create Your Player');
  define('BOX_CREATE_NEW_AVATAR', 'Choose Your Avatar');
  define('CREATE_PLAYER_NAME', 'Player Name:');
  define('CREATE_PLAYER_PWD', 'Password:');
  define('CREATE_PLAYER_CONFIRM', 'Confirm:');
  define('CREATE_PLAYER_EMAIL', 'Email Address:');
  define('CREATE_PLAYER_CHAR_LIMIT', '[ 5-10 chars ]');
  define('CREATE_MSG_IP_BANNED', 'Your IP Address is banned!');
  define('CREATE_MSG_MISSING_DATA', 'Missing fields, please try again.');
  define('CREATE_MSG_AUTHENTICATION_ERROR', 'Authentication Error!');
  define('CREATE_MSG_ALREADY_CREATED', 'You have already created a player!');
  define('CREATE_MSG_INVALID_EMAIL', 'This email address is not valid.');
  define('CREATE_MSG_USERNAME_TAKEN', 'Username already taken. Please try again.');
  define('CREATE_MSG_USERNAME_MWCHECK', 'Username has too many m\'s or w\'s in it!');
  define('CREATE_MSG_USERNAME_CHARS', 'Usernames can contain letters, numbers and underscores.');
  define('CREATE_MSG_USERNAME_LENGTH', 'Your username must be 5-10 characters long.');
  define('CREATE_MSG_PASSWORD_CHARS', 'Passwords can contain letters, numbers and underscores.');
  define('CREATE_MSG_PASSWORD_LENGTH', 'Your password must be 5-10 characters long.');
  define('CREATE_MSG_PASSWORD_CHECK', 'Your password and confirmation must match!');
  define('CREATE_MSG_CHOOSE_AVATAR', 'Please select an avatar');
  define('CREATE_APPROVAL_EMAIL_CONTENT', 'Thank you for applying to join our poker game. Please click the link to activate your player:');
  define('CREATE_APPROVAL_EMAIL_ALERT', 'An activation email has been sent to the address you gave us.');
  define('BUTTON_SUBMIT', 'Submit');



// Game Lobby Page
//-----------------------------------------------------------
  define('TABLE_HEADING_NAME', 'Table Name');
  define('TABLE_HEADING_PLAYERS', 'Players');
  define('TABLE_HEADING_TYPE', 'Table Type');
  define('TABLE_HEADING_BUYIN', 'Buy In');
  define('TABLE_HEADING_SMALL_BLINDS', 'Small Blinds');
  define('TABLE_HEADING_BIG_BLINDS', 'Big Blinds');
  define('TABLE_HEADING_STATUS', 'Table Status');
  define('NEW_GAME', 'New Game');
  define('PLAYING', 'Playing');

// My Player & Player Rankings Pages
//-----------------------------------------------------------
  define('PLAYER_PROFILE', 'Player Profile');
  define('PLAYER_IS_BROKE', 'Your Player Is Broke!!');
  define('PLAYER_STATS', 'Player Statistics:');
  define('PLAYER_CHOOSE_AVATAR', 'Choose Avatar');
  define('PLAYER_CHANGE_PWD', 'Change Password');
  define('BOX_GAME_STATS', 'Answer:');
  define('BOX_MOVE_STATS', 'Administrator');
  define('BOX_HAND_STATS', 'VIP Account');
  define('BOX_FOLD_STATS', 'Terms & Conditions');
  define('BOX_STD_AVATARS', 'Standard Avatars');
  define('BOX_CUSTOM_AVATARS', 'Custom Avatars');

  define('STATS_GAME', 'Game Statistics');
  define('STATS_HAND', 'Hand Statistics');
  define('STATS_MOVE', 'Move Statistics');
  define('STATS_FOLD', 'Fold Statistics');
  define('STATS_PLAYER_NAME', 'Player Name:');
  define('STATS_PLAYER_RANKING', 'Player Ranking:');
  define('STATS_PLAYER_CREATED', 'Player Created:');
  define('STATS_PLAYER_BANKROLL', 'Bankroll:');
  define('STATS_PLAYER_LOGIN', 'Last login:');
  define('STATS_PLAYER_GAMES_PLAYED', 'Games Played:');
  define('STATS_PLAYER_TOURNAMENTS_PLAYED', 'Tournaments Played:');
  define('STATS_PLAYER_TOURNAMENTS_WON', 'Tournaments Won');
  define('STATS_PLAYER_TOURNAMENTS_RATIO', 'Tournament Win Ratio');
  define('STATS_PLAYER_HANDS_PLAYED', 'Hands Played:');
  define('STATS_PLAYER_HANDS_WON', 'Hands Won:');
  define('STATS_PLAYER_HAND_RATIO', 'Hand Win Ratio:');
  define('STATS_PLAYER_FOLD_RATIO', 'Fold Ratio:');
  define('STATS_PLAYER_CHECK_RATIO', 'Check Ratio:');
  define('STATS_PLAYER_CALL_RATIO', 'Call Ratio:');
  define('STATS_PLAYER_RAISE_RATIO', 'Raise Ratio:');
  define('STATS_PLAYER_ALLIN_RATIO', 'All In Ratio:');
  define('STATS_PLAYER_FOLD_PREFLOP', 'Fold Pre-Flop:');
  define('STATS_PLAYER_FOLD_FLOP', 'Fold After Flop');
  define('STATS_PLAYER_FOLD_TURN', 'Fold After Turn:');
  define('STATS_PLAYER_FOLD_RIVER', 'Fold After River:');
  define('STATS_PLAYER_OLD_PWD', 'Old Password:');
  define('STATS_PLAYER_NEW_PWD', 'New Password:');
  define('STATS_PLAYER_CONFIRM_PWD', 'Confirm Password:');
  define('STATS_PLAYER_PWD_CHAR_LIMIT', '[ 5-10 chars ]');
  define('BUTTON_STATS_PLAYER_CREDIT', 'Click here to renew your initial credit');
  define('BUTTON_UPLOAD', 'Upload');

  define('STATS_MSG_FILE_FORMAT', 'Your image must be in jpg format!');
  define('STATS_MSG_FILE_FORMAT', 'Your image must be less than 300kb!');
  define('STATS_MSG_MISSING_DATA', 'Your image must be in jpg format!');
  define('STATS_MSG_PWD_CHARS', 'Passwords can only contain letters and numbers.');
  define('STATS_MSG_PWD_LENGTH', 'Your password must be 5-10 chars long.');
  define('STATS_MSG_PWD_CONFIRM', 'Your new password and confirm fields must match.');
  define('STATS_MSG_PWD_INCORRECT', 'Your old password was incorrect!');

// Admin Panel
//-----------------------------------------------------------
  define('ADMIN_MANAGE_TABLES', 'Manage Tables');
  define('ADMIN_MANAGE_MEMBERS', 'Manage Members');
  define('ADMIN_MANAGE_SETTINGS', 'Game Settings');
  define('ADMIN_MANAGE_STYLES', 'Styles');
  define('ADMIN_SETTINGS_UPDATED', 'Your game settings have been updated!');

  define('ADMIN_GENERAL', 'General Settings');
  define('ADMIN_SETTINGS_TITLE', 'Browser Page Title:');
  define('ADMIN_SETTINGS_EMAIL', 'Require Email Address:');
  define('ADMIN_SETTINGS_APPROVAL', 'Approval Mode:');
  define('ADMIN_SETTINGS_IPCHECK', 'IP Check:');
  define('ADMIN_SETTINGS_LOGIN', 'Bypass Login:');
  define('ADMIN_SETTINGS_SESSNAME', 'Session Name:');
  define('ADMIN_SETTINGS_AUTODELETE', 'Auto Delete Players:');
  define('ADMIN_SETTINGS_STAKESIZE', 'Server Stake Size:');
  define('ADMIN_SETTINGS_BROKE_BUTTON', '"Your Broke" Button:');
  define('ADMIN_TIMER', 'Timer Settings');
  define('ADMIN_SETTINGS_KICK', 'Kick Timer:');
  define('ADMIN_SETTINGS_MOVE', 'Move Timer:');
  define('ADMIN_SETTINGS_SHOWDOWN', 'Showdown Timer:');
  define('ADMIN_SETTINGS_SITOUT', 'Sit Out Timer:');
  define('ADMIN_SETTINGS_DISCONNECT', 'Disconnect Timer:');
  define('ADMIN_SETTINGS_TITLE_HELP', 'This title will appear in your web browsers page title.');
  define('ADMIN_SETTINGS_EMAIL_HELP', 'Select if members need to provide an email address when signing up.');
  define('ADMIN_SETTINGS_APPROVAL_HELP', 'Select automatic, email verification or admin approval.');
  define('ADMIN_SETTINGS_IPCHECK_HELP', 'Prevent multiple players with identical IP addesses playing at the same table.');
  define('ADMIN_SETTINGS_LOGIN_HELP', 'Switch this on if you are using your own session based login system.');
  define('ADMIN_SETTINGS_SESSNAME_HELP', 'Your identifying session name from your own login system.');
  define('ADMIN_SETTINGS_AUTODELETE_HELP', 'Select if you want the system to delete inactive players.');
  define('ADMIN_SETTINGS_STAKESIZE_HELP', 'Switch the server stakes size from tiny stakes to high rollers .');
  define('ADMIN_SETTINGS_BROKE_BUTTON_HELP', '"Turn on/off "Your Broke" module and initial free game stake.');
  define('ADMIN_SETTINGS_KICK_HELP', 'Controls kicking players repeatedly failing to take their turn.');
  define('ADMIN_SETTINGS_MOVE_HELP', 'Controls the time a player has to make their move.');
  define('ADMIN_SETTINGS_SHOWDOWN_HELP', 'Controls the time a showdown hand will be displayed for.');
  define('ADMIN_SETTINGS_SITOUT_HELP', 'Controls the length of stay on the sit out page.');
  define('ADMIN_SETTINGS_DISCONNECT_HELP', 'Controls the time before kicking disconnected players.');
  define('BUTTON_SAVE_SETTINGS', 'Save Settings');

  define('ADMIN_MEMBERS_NAME', 'Player Name');
  define('ADMIN_MEMBERS_RANK', 'Rank');
  define('ADMIN_MEMBERS_EMAIL', 'Email');
  define('ADMIN_MEMBERS_CREATED', 'Created');
  define('ADMIN_MEMBERS_IPADDRESS', 'IP Address');
  define('ADMIN_MEMBERS_APPROVE', 'Approve');
  define('ADMIN_MEMBERS_BAN', 'Ban');
  define('ADMIN_MEMBERS_DELETE', 'Delete');
  define('ADMIN_MEMBERS_RESET_STATS', 'Stats');
  define('BUTTON_APPROVE', 'Approve');
  define('BUTTON_BAN', 'Ban');
  define('BUTTON_UNBAN', 'Unban');
  define('BUTTON_DELETE', 'Delete');
  define('BUTTON_RESET', 'Reset');
  define('BUTTON_CREATE_TABLE', 'Create Table');
  define('BUTTON_INSTALL', 'Install');

  define('ADMIN_TABLES_NAME', 'Table Name');
  define('ADMIN_TABLES_TYPE', 'Table Type');
  define('ADMIN_TABLES_MIN', 'Minimum Buyin');
  define('ADMIN_TABLES_MAX', 'Maximum Buyin');
  define('ADMIN_TABLES_STYLE', 'Table Style');
  define('ADMIN_TABLES_DELETE', 'Delete');

  define('ADMIN_STYLES_INSTALLED', 'Installed Table Styles');
  define('ADMIN_STYLES_PREVIEW', 'Style Preview');
  define('ADMIN_STYLES_NEW_NAME', 'New Style Name');
  define('ADMIN_STYLES_CODE', 'Validation Code');

   define('ADMIN_MSG_STYLE_INSTALLED', 'This style has already been installed!');
   define('ADMIN_MSG_MISSING_DATA', 'Missing data! Please try again.');
   define('ADMIN_MSG_INVALID_CODE', 'Invalid style name or license code!');

// Poker Game Language
//-----------------------------------------------------------
  define('GAME_LOADING', 'Loading...');
  define('GAME_PLAYER_BUYS_IN', 'buys in for');
  define('INSUFFICIENT_BANKROLL_SITNGO', 'Your bank roll is not high enough to play on this table!');
  define('INSUFFICIENT_BANKROLL_TOURNAMENT', 'Your bank roll is not high enough to play in this tournament!');
  define('GAME_STARTING', 'game starting...');
  define('GAME_PLAYER_FOLDS', 'folds');
  define('GAME_PLAYER_CALLS', 'calls');
  define('GAME_PLAYER_CHECKS', 'checks');
  define('GAME_PLAYER_RAISES', 'raises');
  define('GAME_PLAYER_GOES_ALLIN', 'goes all in');
  define('GAME_PLAYER_POT', 'POT:');

  define('GAME_MSG_WON_TOURNAMENT', 'won the last tournament');
  define('GAME_MSG_LOST_CONNECTION', 'has lost connection and leaves the table');
  define('GAME_MSG_PLAYER_BUSTED', 'has busted and leaves the table');
  define('GAME_MSG_PLAYERS_JOINING', 'players joining...');
  define('GAME_MSG_LETS_GO', 'lets go!!');
  define('GAME_MSG_CHIP_LEADER', 'chip leader is');
  define('GAME_MSG_DEALER_BUTTON', 'has the dealer button');
  define('GAME_MSG_DEAL_CARDS', 'dealing the holecards...');
  define('GAME_MSG_DEAL_FLOP', 'dealing the flop...');
  define('GAME_MSG_DEAL_TURN', 'dealing the turn...');
  define('GAME_MSG_DEAL_RIVER', 'dealing the river...');
  define('GAME_MSG_SHOWDOWN', 'SHOWDOWN!');
  define('GAME_MSG_ALLFOLD', 'wins, everyone folded');
  define('GAME_MSG_PLAYER_ALLIN', 'is all in');
  define('GAME_MSG_DEAL_RIVER', 'dealing the river...');
  define('GAME_MSG_SMALL_BLIND', 'posts small blind');
  define('GAME_MSG_BIG_BLIND', 'posts big blind');
  define('GAME_MSG_SPLIT_POT', 'split pot');
  define('GAME_MSG_SPLIT_POT_RESULT', 'The pot is split between the players who have the best');
  define('GAME_MSG_WINNING_HAND', 'winning hand:');
  define('GAME_MSG_PROCESSING', 'processing...');

  define('BUTTON_START', 'Start Game');
  define('BUTTON_CALL', 'Call');
  define('BUTTON_CHECK', 'Check');
  define('BUTTON_FOLD', 'Fold');
  define('BUTTON_BET', 'Bet');
  define('BUTTON_ALLIN', 'All In');

  define('WIN_PAIR', 'pair of'); // e.g. user wins with a pair of 9's
  define('WIN_2PAIR', '2 pair'); // e.g. user wins 2 pair 3's & 8's
  define('WIN_FULLHOUSE', 'full house'); // e.g. user wins with a full house
  define('WIN_SETOF3', 'a set of');  // e.g. user wins with a set of 3's
  define('WIN_SETOF4', 'all the'); // e.g. user wins with all the J's
  define('WIN_FLUSH', 'high flush'); // e.g. user wins with a K high flush
  define('WIN_STRAIGHT_FLUSH', 'straight flush'); // e.g. user wins with a K high straight flush
  define('WIN_ROYALFLUSH', 'royal flush'); // e.g. user wins with a royal flush
  define('WIN_STRAIGHT', 'high straight'); // e.g. user wins with a J high straight
define('WIN_LOW_STRAIGHT', 'low straight'); // e.g. user wins with a low straight
define('WIN_HIGHCARD', 'highcard'); // e.g. user wins with a k highcard

?>