#
# Table structure for table 'pages'
#
CREATE TABLE pages
(
    tx_sitesetup_toc_disabled tinyint(1) DEFAULT 0,
    tx_sitesetup_toc_min int(1) DEFAULT '2' NOT NULL,
    tx_sitesetup_toc_max int(1) DEFAULT '6' NOT NULL
);