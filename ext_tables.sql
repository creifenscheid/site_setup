#
# Table structure for table 'pages'
#
CREATE TABLE pages
(
    tx_sitesetup_toc_disabled tinyint(1) DEFAULT 0,
    tx_sitesetup_toc_min int(1) DEFAULT '2' NOT NULL,
    tx_sitesetup_toc_max int(1) DEFAULT '6' NOT NULL
);

#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content
(
    tx_sitesetup_toc_min int(1) DEFAULT '2' NOT NULL,
    tx_sitesetup_toc_max int(1) DEFAULT '6' NOT NULL,
    tx_sitesetup_carousel_autoslide tinyint(1) DEFAULT 0,
    tx_sitesetup_carousel_slides_to_show int(1) DEFAULT '1' NOT NULL,
    tx_sitesetup_carousel_duration int(2) DEFAULT '5' NOT NULL,
    tx_sitesetup_header_sr_only tinyint(1) DEFAULT 0
);
