/*================================================================================*/
/* DDL SCRIPT                                                                     */
/*================================================================================*/
/*  Title    :                                                                    */
/*  FileName : menu-core.ecm                                                      */
/*  Platform : MySQL 5                                                            */
/*  Version  : Concept                                                            */
/*  Date     : Thursday, May 18, 2023                                             */
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
COMMENT ON TABLE ABC_MENU
Website menu.
*/

/*
COMMENT ON COLUMN ABC_MENU.mnu_id
The PK of the menu.
*/

/*
COMMENT ON COLUMN ABC_MENU.mnu_name
The name of the menu.
*/

/*
COMMENT ON COLUMN ABC_MENU.mnu_class
The PHP class for generating the HTML code of the menu.
*/

/*
COMMENT ON COLUMN ABC_MENU.mnu_label
The stratum label of the menu.
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
COMMENT ON TABLE ABC_MENU_CACHE
The cached HTML code of a website menu.
*/

/*
COMMENT ON COLUMN ABC_MENU_CACHE.mnc_id
The ID of the cached HTML code of the menu.
*/

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
The ID of the language of the menu.
*/

/*
COMMENT ON COLUMN ABC_MENU_CACHE.pro_id
The ID of the profile.
*/

/*
COMMENT ON COLUMN ABC_MENU_CACHE.mnc_html
The cached HTML code of the menu.
*/

CREATE TABLE ABC_MENU_ITEM (
  mni_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  mni_id_parent SMALLINT UNSIGNED,
  mnu_id SMALLINT UNSIGNED NOT NULL,
  pag_id SMALLINT UNSIGNED,
  wrd_id SMALLINT UNSIGNED,
  mni_class1 VARCHAR(80),
  mni_class2 VARCHAR(80),
  mni_class3 VARCHAR(80),
  mni_class4 VARCHAR(80),
  mni_hide_anonymous TINYINT DEFAULT 0 NOT NULL,
  mni_hide_identified TINYINT DEFAULT 0 NOT NULL,
  mni_depth SMALLINT NOT NULL,
  mni_weight SMALLINT NOT NULL,
  CONSTRAINT PK_ABC_MENU_ITEM PRIMARY KEY (mni_id)
);

/*
COMMENT ON TABLE ABC_MENU_ITEM
A menu item in a website menu.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_id
The PK of the menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_id_parent
The ID of the parent menu item of the menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mnu_id
The ID of the menu.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.pag_id
The ID of the page to which the menu item is linking.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.wrd_id
The text of the menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_class1
The CSS class for li element
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_class2
The CSS class for a element
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_class3
The CSS class for first span element.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_class4
The CSS class for second span element
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_hide_anonymous
Whether to hide the menu item for an anonymous user.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_hide_identified
Whether  to hide the menu item for an identified user.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_depth
The depth of the menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM.mni_weight
The weight of the menu item for sorting.
*/

CREATE TABLE ABC_MENU_ITEM_PAGE (
  mip_id SMALLINT UNSIGNED AUTO_INCREMENT NOT NULL,
  mni_id SMALLINT UNSIGNED NOT NULL,
  mnu_id SMALLINT UNSIGNED NOT NULL,
  pag_id SMALLINT UNSIGNED NOT NULL,
  CONSTRAINT PK_ABC_MENU_ITEM_PAGE PRIMARY KEY (mip_id)
);

/*
COMMENT ON TABLE ABC_MENU_ITEM_PAGE
The pages associated with a menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM_PAGE.mip_id
The PK of the associated page of a menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM_PAGE.mni_id
The ID of the menu item.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM_PAGE.mnu_id
The ID of the menu.
*/

/*
COMMENT ON COLUMN ABC_MENU_ITEM_PAGE.pag_id
The ID of the associated page.
*/

/*================================================================================*/
/* CREATE INDEXES                                                                 */
/*================================================================================*/

CREATE UNIQUE INDEX IX_ABC_MENU_CACHE1 ON ABC_MENU_CACHE (lan_id, mnu_id, pro_id);

CREATE UNIQUE INDEX IX_ABC_MENU_ITEM_PAGE1 ON ABC_MENU_ITEM_PAGE (mnu_id, pag_id, mni_id);

/*
COMMENT ON INDEX IX_ABC_MENU_ITEM_PAGE1
Covering index for finding menu item associated with a page.
*/

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
  FOREIGN KEY (pag_id) REFERENCES ABC_AUTH_PAGE (pag_id);

ALTER TABLE ABC_MENU_ITEM_PAGE
  ADD CONSTRAINT FK_ABC_MENU_ITEM_PAGE_ABC_MENU_ITEM
  FOREIGN KEY (mni_id) REFERENCES ABC_MENU_ITEM (mni_id);

ALTER TABLE ABC_MENU_ITEM_PAGE
  ADD CONSTRAINT FK_ABC_MENU_ITEM_PAGE_AUT_PAGE
  FOREIGN KEY (pag_id) REFERENCES ABC_AUTH_PAGE (pag_id);

ALTER TABLE ABC_MENU_ITEM_PAGE
  ADD CONSTRAINT FK_ABC_MENU_ITEM_PAGE_ABC_MENU
  FOREIGN KEY (mnu_id) REFERENCES ABC_MENU (mnu_id);
