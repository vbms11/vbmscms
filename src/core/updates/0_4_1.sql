

ALTER TABLE `t_site_template` ADD `main` BOOL NOT NULL DEFAULT '0' AFTER `templateid`;

update t_module set static = '1' where sysname in ('login','search','pages');

CREATE TABLE IF NOT EXISTS `t_cms_version` (
  `version` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

insert into t_cms_version(`version`) values(0.41);

alter table `t_page` add `code` varchar(40)

