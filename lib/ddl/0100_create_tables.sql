/*================================================================================*/
/* DDL SCRIPT                                                                     */
/*================================================================================*/
/*  Title    :                                                                    */
/*  FileName : menu.ecm                                                           */
/*  Platform : MySQL 5                                                            */
/*  Version  : Concept                                                            */
/*  Date     : zondag 7 juni 2020                                                 */
/*================================================================================*/
/*================================================================================*/
/* CREATE TABLES                                                                  */
/*================================================================================*/

CREATE TABLE ABC_MENU (
  mnu_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  mnu_name VARCHAR(128) NOT NULL,
  mnu_class VARCHAR(128) NOT NULL,
  mnu_label VARCHAR(128) CHARACTER SET ascii COLLATE ascii_general_ci,
  CONSTRAINT PK_ABC_MENU PRIMARY KEY (mnu_id)
);

/*
COMMENT ON COLUMN ABC_MENU.mnu_class
The PHP class for generating the HMTL code of the menu.
*/

CREATE TABLE ABC_MENU_CACHE (
  mnc_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  mnu_id SMALLINT UNSIGNED NOT NULL,
  cmp_id SMALLINT UNSIGNED NOT NULL,
  lan_id TINYINT UNSIGNED NOT NULL,
  pro_id SMALLINT UNSIGNED NOT NULL,
  mnc_html LONGTEXT,
  CONSTRAINT PK_ABC_MENU_CACHE PRIMARY KEY (mnc_id)
);

/*
COMMENT ON COLUMN ABC_MENU_CACHE.mnu_id
The ID of the menu.
*/

/*
COMMENT ON COLUMN ABC_MENU_CACHE.cmp_id
The ID of the company.
*/

/*
COMMENT ON COLUMN ABC_MENU_CACHE.lan_id
The ID of the langugae.
*/

/*
COMMENT ON COLUMN ABC_MENU_CACHE.pro_id
The ID of the profile.
*/

/*
COMMENT ON COLUMN ABC_MENU_CACHE.mnc_html
The HMTL code of the menu.
*/

CREATE TABLE ABC_MENU_ITEM (
  mni_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  mni_id_parent SMALLINT UNSIGNED,
  mnu_id SMALLINT UNSIGNED NOT NULL,
  pag_id SMALLINT UNSIGNED,
  wrd_id SMALLINT UNSIGNED,
  mni_hide_anonymous TINYINT DEFAULT 0 NOT NULL,
  mni_hide_identified TINYINT DEFAULT 0 NOT NULL,
  mni_depth SMALLINT NOT NULL,
  mni_weight SMALLINT NOT NULL,
  CONSTRAINT PK_ABC_MENU_ITEM PRIMARY KEY (mni_id)
);

/*
COMMENT ON COLUMN ABC_MENU_ITEM.wrd_id
The text of this menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_hide_anonymous
Hide this menu item for anymouse user.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_hide_identified
Hide this menu item for identified user.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_depth
The depth of this menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_weight
The weight of this menu item for sorting.
*/

/*================================================================================*/
/* CREATE INDEXES                                                                 */
/*================================================================================*/

CREATE UNIQUE INDEX IX_ABC_MENU_CACHE1 ON ABC_MENU_CACHE (lan_id, mnu_id, pro_id);

/*================================================================================*/
/* CREATE FOREIGN KEYS                                                            */
/*================================================================================*/

ALTER TABLE ABC_MENU_CACHE
  ADD CONSTRAINT FK_AMC_MENU_CACHE_ABC_AUTH_COMPANY
  FOREIGN KEY (cmp_id) REFERENCES ABC_AUTH_COMPANY (cmp_id);

ALTER TABLE ABC_MENU_CACHE
  ADD CONSTRAINT FK_AMC_MENU_CACHE_ABC_AUTH_PROFILE
  FOREIGN KEY (pro_id) REFERENCES ABC_AUTH_PROFILE (pro_id);

ALTER TABLE ABC_MENU_CACHE
  ADD CONSTRAINT FK_AMC_MENU_CACHE_ABC_BABEL_LANGUAGE
  FOREIGN KEY (lan_id) REFERENCES ABC_BABEL_LANGUAGE (lan_id);

ALTER TABLE ABC_MENU_CACHE
  ADD CONSTRAINT FK_AMC_MENU_CACHE_ABC_MENU
  FOREIGN KEY (mnu_id) REFERENCES ABC_MENU (mnu_id)
  ON DELETE CASCADE;

ALTER TABLE ABC_MENU_ITEM
  ADD CONSTRAINT FK_ABC_MENU_ITEM_ABC_BABEL_WORD
  FOREIGN KEY (wrd_id) REFERENCES ABC_BABEL_WORD (wrd_id);

ALTER TABLE ABC_MENU_ITEM
  ADD CONSTRAINT FK_ABC_MENU_ITEM_ABC_MENU
  FOREIGN KEY (mnu_id) REFERENCES ABC_MENU (mnu_id);

ALTER TABLE ABC_MENU_ITEM
  ADD CONSTRAINT FK_ABC_MENU_ITEM_ABC_MENU_ITEM
  FOREIGN KEY (mni_id_parent) REFERENCES ABC_MENU_ITEM (mni_id);

ALTER TABLE ABC_MENU_ITEM
  ADD CONSTRAINT FK_ABC_MENU_ITEM_AUT_PAGE
  FOREIGN KEY (pag_id) REFERENCES AUT_PAGE (pag_id);
