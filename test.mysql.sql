-- MySql Example Database
-- Database: test

-- Table:
CREATE TABLE IF NOT EXISTS `test` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `params` varchar(255) NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- Example data:
INSERT INTO `test` (`test_id`, `name`, `params`) VALUES
(1, 'test', 'test_params'),
(2, 'test2', 'test2_params'),
(3, 'test3', 'test3_params');