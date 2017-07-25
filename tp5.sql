-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-07-25 13:46:33
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tp5`
--

-- --------------------------------------------------------

--
-- 表的结构 `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `name` varchar(40) NOT NULL COMMENT '广告名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '广告类型 1图片2动画',
  `picurl` varchar(60) NOT NULL COMMENT '图片地址',
  `link` varchar(60) NOT NULL COMMENT '跳转地址',
  `ison` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',
  `posid` mediumint(8) unsigned NOT NULL COMMENT '广告位ID',
  PRIMARY KEY (`id`),
  KEY `posid` (`posid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `ad`
--

INSERT INTO `ad` (`id`, `name`, `type`, `picurl`, `link`, `ison`, `posid`) VALUES
(1, '小米3真理333ff', 1, './uploads/ad/8899149944008926432.jpg', 'mi.com3344ff33', 1, 1),
(2, '小米3真理', 1, './uploads/ad/20642149939487724883.jpg', 'mi.com', 1, 0),
(3, '懒得买', 2, '', '', 1, 1),
(4, '中国猛', 2, '', '', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `ad_pic`
--

CREATE TABLE IF NOT EXISTS `ad_pic` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告图片ID',
  `imgurl` varchar(60) NOT NULL COMMENT '图片地址',
  `links` varchar(60) NOT NULL COMMENT '跳转地址',
  `adid` mediumint(8) unsigned NOT NULL COMMENT '广告ID',
  PRIMARY KEY (`id`),
  KEY `adid` (`adid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `ad_pic`
--

INSERT INTO `ad_pic` (`id`, `imgurl`, `links`, `adid`) VALUES
(1, './uploads/ad/24275149939614823056.jpg', 'lanm.com', 3),
(7, './uploads/ad/3965149944004824178.jpg', 'du.comdd', 4),
(6, './uploads/ad/30165149943995616874.jpg', 'bai.com33', 4),
(4, './uploads/ad/542314994326961852.jpg', '111', 3),
(5, './uploads/ad/29631149943773510892.jpg', 'ds', 3),
(8, './uploads/ad/315271499439786468.jpg', 'lai.coms', 4),
(9, './uploads/ad/9810149944061132035.jpg', 'ff', 3);

-- --------------------------------------------------------

--
-- 表的结构 `ad_pos`
--

CREATE TABLE IF NOT EXISTS `ad_pos` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告位ID',
  `pname` varchar(40) NOT NULL COMMENT '广告位名称',
  `width` smallint(5) unsigned NOT NULL COMMENT '广告位宽度',
  `height` smallint(5) unsigned NOT NULL COMMENT '广告位高度',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `ad_pos`
--

INSERT INTO `ad_pos` (`id`, `pname`, `width`, `height`) VALUES
(1, '首页轮播图', 1024, 500);

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `title` varchar(40) NOT NULL COMMENT '文章标题',
  `content` text NOT NULL COMMENT '文章内容',
  `cate_id` mediumint(8) unsigned NOT NULL COMMENT '所属栏目',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `title`, `content`, `cate_id`) VALUES
(2, '售后流程', '<p>啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊</p>', 1),
(3, '购物流程', '<p>白斑病白斑病白斑病白斑病白斑病白斑病白斑病吧</p>', 1),
(4, '订购方式', '<p>草草草草草草草草草草草草草草草草草草草草草草草草草</p>', 1),
(5, '如何粉笔原装电池', '<p>反反复复反反复复反反复复反反复复反反复复反反复复反反复复</p>', 2),
(6, '如何封闭水货手机', '<p>滴答滴答滴答滴答滴答滴答滴答滴答滴答滴答滴答</p>', 2),
(7, '如何享受全国链表', '<p>滴答滴答滴答滴答滴答滴答滴答滴答滴答滴答滴答滴答滴答滴</p>', 2);

-- --------------------------------------------------------

--
-- 表的结构 `attr`
--

CREATE TABLE IF NOT EXISTS `attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '属性ID',
  `attr_name` varchar(20) NOT NULL COMMENT '属性名称',
  `attr_type` tinyint(1) NOT NULL COMMENT '属性类型',
  `attr_value` text NOT NULL COMMENT '属性值',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '所属类型',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `attr`
--

INSERT INTO `attr` (`id`, `attr_name`, `attr_type`, `attr_value`, `type_id`) VALUES
(18, '尺码', 1, 'M,ML,XML', 4),
(19, '面料', 0, '', 4),
(20, '工艺', 0, '', 4),
(21, '款式', 0, '', 4),
(22, '厚薄', 0, '薄款,厚款', 4),
(23, '适用年龄', 0, '18-24岁,25-30岁,31-40岁,41-50岁', 4),
(17, '颜色', 1, '黑色,白色,红色,蓝色', 4);

-- --------------------------------------------------------

--
-- 表的结构 `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '品牌ID',
  `brand_name` varchar(30) NOT NULL COMMENT '品牌名称',
  `brand_logo` varchar(100) NOT NULL COMMENT '品牌LOGO',
  `brand_url` varchar(100) NOT NULL COMMENT '品牌地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `brand`
--

INSERT INTO `brand` (`id`, `brand_name`, `brand_logo`, `brand_url`) VALUES
(2, '361度', '', ''),
(3, '阿迪达斯', '', ''),
(4, '阿玛尼', '', ''),
(5, '耐克', '', ''),
(6, '乔丹', '', ''),
(7, '李宁', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `cate`
--

CREATE TABLE IF NOT EXISTS `cate` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `cate_name` varchar(30) NOT NULL COMMENT '栏目名称',
  `pid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '栏目PID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- 转存表中的数据 `cate`
--

INSERT INTO `cate` (`id`, `cate_name`, `pid`) VALUES
(22, '内衣', 17),
(21, '开衫', 18),
(20, '套头衫', 18),
(19, '针织背心', 18),
(18, '针织衫', 17),
(17, '男装', 0),
(23, '内衣/套装', 22),
(24, '袜子', 22),
(25, '家居服', 22),
(26, '内裤', 22),
(27, '外套', 17),
(28, '皮衣/皮草', 27),
(29, '卫衣', 27),
(30, '风衣', 27),
(31, '大衣', 27),
(32, '西服', 27),
(33, '女装', 0),
(34, 'T恤/POLO', 33),
(35, 'POLO衫', 34),
(36, '短袖T恤', 34),
(37, '长袖T恤', 34),
(38, '衬衫', 33),
(39, '长袖衬衫', 38),
(40, '短袖衬衫', 38),
(41, '裤子', 33),
(42, '牛仔分裤', 41),
(43, '牛仔短裤', 41),
(44, '休闲裤', 41),
(45, '牛仔裤', 41),
(46, '休闲短裤', 41),
(47, '哈伦裤', 41),
(48, '连身裤', 41),
(49, '打底裤', 41),
(50, '运动户外', 0),
(51, '运动鞋', 50),
(52, '户外装备', 50),
(53, '户外鞋服', 50),
(54, '运动器械', 50),
(55, '户外服饰', 53),
(56, '户外鞋袜', 53),
(57, '户外配饰', 53),
(58, '帐篷', 52),
(59, '睡袋', 52),
(60, '登山攀岩', 52),
(61, '户外背包', 52),
(62, '户外照明', 52);

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `name` varchar(40) NOT NULL COMMENT '栏目名称',
  `type` tinyint(1) unsigned NOT NULL COMMENT '栏目类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `type`) VALUES
(1, '新手上路', 1),
(2, '购物常识', 1);

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置项ID',
  `enname` varchar(30) NOT NULL COMMENT '配置英文名称',
  `cnname` varchar(30) NOT NULL COMMENT '配置中文名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '配置类型:1文本框2文本域3单选按钮4复选框5下拉菜单',
  `values` varchar(160) NOT NULL COMMENT '配置可选值',
  `value` varchar(60) NOT NULL COMMENT '配置选定值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`id`, `enname`, `cnname`, `type`, `values`, `value`) VALUES
(1, 'name', '站点名称', 1, '', '我的商城'),
(2, 'pagenum', '分页数', 3, '10,12,14', '12'),
(3, 'keywords', '关键词', 2, '', '商城，男装，女装'),
(4, 'istalk', '是否开启评论', 4, '是', ''),
(5, 'delpro', '何时减库存', 5, '提交订单,支付成功,收到商品', '支付成功'),
(8, 'hotsearch', '热门搜索', 2, '', '男装，女装，团购'),
(6, 'beian', '备案号', 1, '', '100033'),
(7, 'description', '网站描述', 2, '', '这是一个商城网站');

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `goods_name` varchar(30) NOT NULL COMMENT '商品名称',
  `goods_sn` char(16) NOT NULL COMMENT '商品编码',
  `original` varchar(100) NOT NULL COMMENT '原图',
  `sm_thumb` varchar(100) NOT NULL COMMENT '小缩略图',
  `mid_thumb` varchar(100) NOT NULL COMMENT '中缩略图',
  `max_thumb` varchar(100) NOT NULL COMMENT '大缩略图',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `onsale` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否上架',
  `cate_id` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '所属栏目',
  `brand_id` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '所属品牌',
  `type_id` mediumint(9) unsigned NOT NULL DEFAULT '0' COMMENT '所属类型',
  `goods_desc` text NOT NULL COMMENT '商品详情',
  `goods_weight` decimal(10,2) NOT NULL COMMENT '商品重量',
  `weight_unit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '重量单位',
  PRIMARY KEY (`id`),
  KEY `cate_id` (`cate_id`,`brand_id`,`type_id`),
  KEY `shop_price` (`shop_price`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `goods`
--

INSERT INTO `goods` (`id`, `goods_name`, `goods_sn`, `original`, `sm_thumb`, `mid_thumb`, `max_thumb`, `market_price`, `shop_price`, `onsale`, `cate_id`, `brand_id`, `type_id`, `goods_desc`, `goods_weight`, `weight_unit`) VALUES
(9, '韩版美女衫', '1499921720274251', './uploads/goods/28025149994934210942.jpg', './uploads/goods/sm_28025149994934210942.jpg', './uploads/goods/mid_28025149994934210942.jpg', './uploads/goods/max_28025149994934210942.jpg', '400.00', '300.00', 1, 40, 4, 4, '<p>美女<br/></p>', '12.00', 0),
(10, '潮流POLO衫', '1499922076713460', './uploads/goods/20931149994932727200.jpg', './uploads/goods/sm_20931149994932727200.jpg', './uploads/goods/mid_20931149994932727200.jpg', './uploads/goods/max_20931149994932727200.jpg', '233.00', '200.00', 1, 35, 3, 4, '<p>没vn</p>', '23.00', 0),
(11, '时尚女裤', '1499922266607638', './uploads/goods/26237149994931326994.jpg', './uploads/goods/sm_26237149994931326994.jpg', './uploads/goods/mid_26237149994931326994.jpg', './uploads/goods/max_26237149994931326994.jpg', '111.00', '100.00', 1, 45, 3, 4, '<p>合欢</p>', '12.00', 0),
(12, '美女短裙', '1499922352345296', './uploads/goods/14887149994929721716.jpg', './uploads/goods/sm_14887149994929721716.jpg', './uploads/goods/mid_14887149994929721716.jpg', './uploads/goods/max_14887149994929721716.jpg', '233.00', '222.00', 1, 46, 2, 4, '<p>22</p>', '22.00', 0),
(13, '美女背心', '1499922445747721', './uploads/goods/5953149994927825830.jpg', './uploads/goods/sm_5953149994927825830.jpg', './uploads/goods/mid_5953149994927825830.jpg', './uploads/goods/max_5953149994927825830.jpg', '22.00', '11.00', 1, 36, 5, 4, '', '2.00', 0),
(14, '风度男装', '1499922575659315', './uploads/goods/9291149994926032296.jpg', './uploads/goods/sm_9291149994926032296.jpg', './uploads/goods/mid_9291149994926032296.jpg', './uploads/goods/max_9291149994926032296.jpg', '222.00', '122.00', 1, 30, 4, 4, '', '22.00', 0),
(15, '猛男皮夹克', '1499922658918511', './uploads/goods/965149994924620762.jpg', './uploads/goods/sm_965149994924620762.jpg', './uploads/goods/mid_965149994924620762.jpg', './uploads/goods/max_965149994924620762.jpg', '222.00', '111.00', 1, 28, 5, 4, '', '23.00', 0),
(16, '男毛衫', '1499922741333197', './uploads/goods/29743149994923131292.jpg', './uploads/goods/sm_29743149994923131292.jpg', './uploads/goods/mid_29743149994923131292.jpg', './uploads/goods/max_29743149994923131292.jpg', '222.00', '111.00', 1, 19, 7, 4, '', '22.00', 0),
(17, '型男服装', '1499922817280110', './uploads/goods/2868114999492188718.jpg', './uploads/goods/sm_2868114999492188718.jpg', './uploads/goods/mid_2868114999492188718.jpg', './uploads/goods/max_2868114999492188718.jpg', '222.00', '221.00', 1, 29, 2, 4, '', '21.00', 0),
(18, '美女短裤', '1499922906143581', './uploads/goods/2006514999491427558.jpg', './uploads/goods/sm_2006514999491427558.jpg', './uploads/goods/mid_2006514999491427558.jpg', './uploads/goods/max_2006514999491427558.jpg', '222.00', '211.00', 1, 43, 2, 4, '', '11.00', 0),
(19, '大气时尚女装', '1499950293655219', './uploads/goods/25980149995029311781.jpg', './uploads/goods/sm_25980149995029311781.jpg', './uploads/goods/mid_25980149995029311781.jpg', './uploads/goods/max_25980149995029311781.jpg', '222.00', '111.00', 1, 35, 2, 4, '<p>11</p>', '11.00', 0),
(20, '美女服饰', '1500186108882269', './uploads/goods/13918150018610831295.jpg', './uploads/goods/sm_13918150018610831295.jpg', './uploads/goods/mid_13918150018610831295.jpg', './uploads/goods/max_13918150018610831295.jpg', '222.00', '111.00', 1, 35, 2, 4, '<p><br/></p><p><br/><img alt="" id="a89a52c365c84d00b5d382b7b8d75e78 " class="" src="//img30.360buyimg.com/popWaterMark/jfs/t5434/124/94368989/242488/4016ef80/58f8874fNe68bf2cf.jpg"/><img alt="" id="3ac873f99b114250b08e3aac61697076 " class="" src="//img30.360buyimg.com/popWaterMark/jfs/t4945/229/1755173706/428637/699a5cf8/58f470aaNf01df63f.jpg"/></p>', '11.00', 0);

-- --------------------------------------------------------

--
-- 表的结构 `goods_attr`
--

CREATE TABLE IF NOT EXISTS `goods_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `attr_id` mediumint(8) unsigned NOT NULL COMMENT '属性ID',
  `attr_value` varchar(150) NOT NULL COMMENT '属性值',
  `attr_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '属性价格',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=163 ;

--
-- 转存表中的数据 `goods_attr`
--

INSERT INTO `goods_attr` (`id`, `goods_id`, `attr_id`, `attr_value`, `attr_price`) VALUES
(75, 9, 17, '黑色', '10.00'),
(71, 9, 21, '杀马特', '0.00'),
(70, 9, 20, '手工打造', '0.00'),
(69, 9, 19, '丝绸', '0.00'),
(76, 9, 17, '蓝色', '5.00'),
(68, 9, 18, 'XML', '12.00'),
(67, 9, 18, 'ML', '8.00'),
(66, 9, 18, 'M', '5.00'),
(74, 9, 17, '白色', '14.00'),
(73, 9, 23, '18-24岁', '0.00'),
(72, 9, 22, '薄款', '0.00'),
(79, 10, 18, 'XML', '15.00'),
(78, 10, 18, 'ML', '10.00'),
(77, 10, 18, 'M', '5.00'),
(82, 10, 21, '潮流', '0.00'),
(81, 10, 20, '精工', '0.00'),
(80, 10, 19, '棉', '0.00'),
(83, 10, 22, '薄款', '0.00'),
(84, 10, 23, '18-24岁', '0.00'),
(85, 10, 17, '黑色', '0.00'),
(86, 10, 17, '白色', '0.00'),
(87, 11, 18, 'M', '0.00'),
(88, 11, 18, 'ML', '0.00'),
(89, 11, 18, 'XML', '0.00'),
(90, 11, 19, '尼龙', '0.00'),
(91, 11, 20, '精工', '0.00'),
(92, 11, 21, '时尚', '0.00'),
(93, 11, 22, '薄款', '0.00'),
(94, 11, 23, '18-24岁', '0.00'),
(95, 11, 17, '蓝色', '0.00'),
(96, 12, 18, 'M', '0.00'),
(97, 12, 19, '尼龙', '0.00'),
(98, 12, 20, '手工打造', '0.00'),
(99, 12, 21, '时尚', '0.00'),
(100, 12, 22, '薄款', '0.00'),
(101, 12, 23, '18-24岁', '0.00'),
(102, 12, 17, '黑色', '0.00'),
(103, 13, 18, 'M', '0.00'),
(104, 13, 19, '纱', '0.00'),
(105, 13, 20, '薄', '0.00'),
(106, 13, 21, '潮流', '0.00'),
(107, 13, 22, '薄款', '0.00'),
(108, 13, 23, '18-24岁', '0.00'),
(109, 13, 17, '白色', '0.00'),
(110, 14, 18, 'XML', '0.00'),
(111, 14, 19, '皮', '0.00'),
(112, 14, 20, '精细', '0.00'),
(113, 14, 21, '大气', '0.00'),
(114, 14, 22, '厚款', '0.00'),
(115, 14, 23, '31-40岁', '0.00'),
(116, 14, 17, '黑色', '0.00'),
(117, 15, 18, 'XML', '0.00'),
(118, 15, 19, '劈', '0.00'),
(119, 15, 20, '好', '0.00'),
(120, 15, 21, '黑', '0.00'),
(121, 15, 22, '厚款', '0.00'),
(122, 15, 23, '18-24岁', '0.00'),
(123, 15, 17, '黑色', '0.00'),
(124, 16, 18, 'M', '0.00'),
(125, 16, 19, '毛', '0.00'),
(126, 16, 20, '手工', '0.00'),
(127, 16, 21, '大气', '0.00'),
(128, 16, 22, '薄款', '0.00'),
(129, 16, 23, '31-40岁', '0.00'),
(130, 16, 17, '黑色', '0.00'),
(131, 17, 18, 'ML', '0.00'),
(132, 17, 19, '劈', '0.00'),
(133, 17, 20, '收', '0.00'),
(134, 17, 21, '大气', '0.00'),
(135, 17, 22, '薄款', '0.00'),
(136, 17, 23, '25-30岁', '0.00'),
(137, 17, 17, '黑色', '0.00'),
(138, 18, 18, 'M', '0.00'),
(139, 18, 19, '尼龙', '0.00'),
(140, 18, 20, '精工', '0.00'),
(141, 18, 21, '时尚', '0.00'),
(142, 18, 22, '薄款', '0.00'),
(143, 18, 23, '18-24岁', '0.00'),
(144, 18, 17, '蓝色', '0.00'),
(145, 19, 18, 'M', '0.00'),
(146, 19, 19, '布料', '0.00'),
(147, 19, 20, '精细', '0.00'),
(148, 19, 21, '潮流', '0.00'),
(149, 19, 22, '薄款', '0.00'),
(150, 19, 23, '18-24岁', '0.00'),
(151, 19, 17, '白色', '0.00'),
(152, 20, 18, 'M', '11.00'),
(153, 20, 18, 'ML', '22.00'),
(154, 20, 18, 'XML', '33.00'),
(155, 20, 19, '布料', '0.00'),
(156, 20, 20, '精品', '0.00'),
(157, 20, 21, '潮流', '0.00'),
(158, 20, 22, '薄款', '0.00'),
(159, 20, 23, '18-24岁', '0.00'),
(160, 20, 17, '黑色', '11.00'),
(161, 20, 17, '白色', '22.00'),
(162, 20, 17, '红色', '33.00');

-- --------------------------------------------------------

--
-- 表的结构 `goods_pic`
--

CREATE TABLE IF NOT EXISTS `goods_pic` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品图片ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `original` varchar(100) NOT NULL COMMENT '原图',
  `sm_thumb` varchar(100) NOT NULL COMMENT '小缩略图',
  `max_thumb` varchar(100) NOT NULL COMMENT '大缩略图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- 转存表中的数据 `goods_pic`
--

INSERT INTO `goods_pic` (`id`, `goods_id`, `original`, `sm_thumb`, `max_thumb`) VALUES
(17, 9, './uploads/goods/534314999217201324.jpg', './uploads/goods/sm_534314999217201324.jpg', './uploads/goods/max_534314999217201324.jpg'),
(18, 20, './uploads/goods/8277150018610823146.jpg', './uploads/goods/sm_8277150018610823146.jpg', './uploads/goods/max_8277150018610823146.jpg'),
(19, 20, './uploads/goods/31579150018610828664.jpg', './uploads/goods/sm_31579150018610828664.jpg', './uploads/goods/max_31579150018610828664.jpg'),
(20, 20, './uploads/goods/27857150018610813110.jpg', './uploads/goods/sm_27857150018610813110.jpg', './uploads/goods/max_27857150018610813110.jpg'),
(21, 20, './uploads/goods/2923915001861085028.jpg', './uploads/goods/sm_2923915001861085028.jpg', './uploads/goods/max_2923915001861085028.jpg'),
(22, 20, './uploads/goods/1293150018610819650.jpg', './uploads/goods/sm_1293150018610819650.jpg', './uploads/goods/max_1293150018610819650.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `username` varchar(20) NOT NULL COMMENT '管理员用户名',
  `password` char(32) NOT NULL COMMENT '管理员密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `manager`
--

INSERT INTO `manager` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(30) NOT NULL COMMENT '用户名称',
  `password` char(32) NOT NULL COMMENT '用户密码',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `check_mail` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱是否验证0未验证1已验证',
  `mail_str` varchar(32) NOT NULL COMMENT '邮箱验证字符串',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别:0保密1男2女',
  `regtime` int(10) unsigned NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`id`, `username`, `password`, `email`, `check_mail`, `mail_str`, `sex`, `regtime`) VALUES
(5, 'xiexie', '4297f44b13955235245b2497399d7a93', '448408740@qq.com', 0, '2f09a0ebdd1532967d9dee022df370c0', 0, 1500110736);

-- --------------------------------------------------------

--
-- 表的结构 `member_level`
--

CREATE TABLE IF NOT EXISTS `member_level` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员等级ID',
  `level_name` varchar(20) NOT NULL COMMENT '等级名称',
  `points_min` int(10) unsigned NOT NULL COMMENT '最小折扣',
  `points_max` int(10) unsigned NOT NULL COMMENT '最大折扣',
  `rate` tinyint(3) unsigned NOT NULL COMMENT '折扣率',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `member_level`
--

INSERT INTO `member_level` (`id`, `level_name`, `points_min`, `points_max`, `rate`) VALUES
(1, '注册用户', 0, 10000, 100),
(2, '中级会员', 0, 2000, 90),
(3, '高级会员', 0, 3000, 80),
(4, 'VIP会员', 0, 4000, 70);

-- --------------------------------------------------------

--
-- 表的结构 `member_price`
--

CREATE TABLE IF NOT EXISTS `member_price` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员价格ID',
  `price` decimal(10,2) NOT NULL COMMENT '会员等级价格',
  `level_id` mediumint(8) unsigned NOT NULL COMMENT '等级ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- 转存表中的数据 `member_price`
--

INSERT INTO `member_price` (`id`, `price`, `level_id`, `goods_id`) VALUES
(48, '166.00', 4, 10),
(47, '177.00', 3, 10),
(46, '188.00', 2, 10),
(45, '199.00', 1, 10),
(44, '0.00', 4, 9),
(43, '0.00', 3, 9),
(42, '0.00', 2, 9),
(41, '0.00', 1, 9),
(52, '0.00', 4, 11),
(51, '0.00', 3, 11),
(50, '0.00', 2, 11),
(49, '0.00', 1, 11),
(56, '0.00', 4, 12),
(55, '0.00', 3, 12),
(54, '0.00', 2, 12),
(53, '0.00', 1, 12),
(60, '0.00', 4, 13),
(59, '0.00', 3, 13),
(58, '0.00', 2, 13),
(57, '0.00', 1, 13),
(61, '0.00', 1, 14),
(62, '0.00', 2, 14),
(63, '0.00', 3, 14),
(64, '0.00', 4, 14),
(65, '0.00', 1, 15),
(66, '0.00', 2, 15),
(67, '0.00', 3, 15),
(68, '0.00', 4, 15),
(69, '0.00', 1, 16),
(70, '0.00', 2, 16),
(71, '0.00', 3, 16),
(72, '0.00', 4, 16),
(73, '0.00', 1, 17),
(74, '0.00', 2, 17),
(75, '0.00', 3, 17),
(76, '0.00', 4, 17),
(77, '11.00', 1, 18),
(78, '11.00', 2, 18),
(79, '11.00', 3, 18),
(80, '11.00', 4, 18),
(81, '0.00', 1, 19),
(82, '0.00', 2, 19),
(83, '0.00', 3, 19),
(84, '0.00', 4, 19),
(85, '0.00', 1, 20),
(86, '0.00', 2, 20),
(87, '0.00', 3, 20),
(88, '0.00', 4, 20);

-- --------------------------------------------------------

--
-- 表的结构 `nav`
--

CREATE TABLE IF NOT EXISTS `nav` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '导航ID',
  `nav_name` varchar(30) NOT NULL COMMENT '导航名称',
  `nav_url` varchar(150) NOT NULL COMMENT '导航地址',
  `nav_blank` tinyint(1) NOT NULL DEFAULT '1' COMMENT '导航打开方式：0当前页1新页面',
  `nav_pos` tinyint(1) NOT NULL DEFAULT '2' COMMENT '导航位置：1顶部2中间3底部',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `nav`
--

INSERT INTO `nav` (`id`, `nav_name`, `nav_url`, `nav_blank`, `nav_pos`) VALUES
(2, '女装', '/', 1, 2),
(3, '男装', '/', 1, 2),
(4, '裤子', '/', 1, 2),
(5, '品牌专区', '/', 1, 2),
(6, '团购', '/', 1, 2),
(7, '免责条款', '/', 1, 3),
(8, '隐私保护', '/', 1, 3),
(9, '咨询热点', '/', 1, 3),
(10, '联系我们', '/', 1, 3),
(11, '公司简介', '/', 1, 3),
(12, '批发方案', '/', 1, 3),
(13, '配送方式', '/', 1, 3),
(14, '我的账户', '/', 1, 1),
(15, '选购中心', '/', 1, 1),
(16, '标签云', '/', 1, 1),
(17, '报价单', '/', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `sn` char(16) NOT NULL COMMENT '订单编号',
  `addtime` int(11) NOT NULL COMMENT '下单时间',
  `shr` varchar(30) NOT NULL COMMENT '收货人',
  `province` varchar(30) NOT NULL COMMENT '省',
  `city` varchar(30) NOT NULL COMMENT '市',
  `county` varchar(60) NOT NULL COMMENT '县',
  `adress` varchar(255) NOT NULL COMMENT '详细地址',
  `phone` varchar(11) NOT NULL COMMENT '电话',
  `mid` mediumint(8) unsigned NOT NULL COMMENT '会员ID',
  `peisong` varchar(30) NOT NULL COMMENT '配送方式',
  `pay` varchar(30) NOT NULL COMMENT '支付方式',
  `gtprice` decimal(10,2) NOT NULL COMMENT '商品总价',
  `yprice` decimal(10,2) NOT NULL COMMENT '运费价格',
  `tprice` decimal(10,2) NOT NULL COMMENT '订单总价',
  `order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未确认，1以确认，2申请退货，3退货成功',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未支付，1已支付',
  `fh_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0未发货，1已发货，2已收货',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `sn`, `addtime`, `shr`, `province`, `city`, `county`, `adress`, `phone`, `mid`, `peisong`, `pay`, `gtprice`, `yprice`, `tprice`, `order_status`, `pay_status`, `fh_status`) VALUES
(1, '', 0, '小米', '湖北省', '地级市', '市、县级市', '信息信息', '13455554444', 0, '顺丰', '支付宝', '763.00', '0.00', '0.00', 0, 0, 0),
(2, '1500882563302544', 1500882563, '小红', '安徽省', '亳州市', '城关镇', '小红的家', '13455556666', 5, '申通', '余额', '763.00', '0.00', '0.00', 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `order_goods`
--

CREATE TABLE IF NOT EXISTS `order_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `goods_attr_id` varchar(60) NOT NULL COMMENT '属性ID',
  `goods_attr_str` varchar(150) NOT NULL COMMENT '属性字符串',
  `goods_price` decimal(10,2) unsigned NOT NULL COMMENT '本店价格',
  `goods_marketprice` decimal(10,2) unsigned NOT NULL COMMENT '市场价格',
  `goods_num` smallint(5) unsigned NOT NULL COMMENT '商品数量',
  `order_id` mediumint(8) unsigned NOT NULL COMMENT '订单ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `order_goods`
--

INSERT INTO `order_goods` (`id`, `goods_id`, `goods_name`, `goods_attr_id`, `goods_attr_str`, `goods_price`, `goods_marketprice`, `goods_num`, `order_id`) VALUES
(1, 10, '潮流POLO衫', '79,85', '尺码:XML [+15.00]<br/>颜色:黑色', '200.00', '233.00', 2, 1),
(2, 19, '大气时尚女装', '145,151', '尺码:M<br/>颜色:白色', '111.00', '222.00', 1, 1),
(3, 12, '美女短裙', '96,102', '尺码:M<br/>颜色:黑色', '222.00', '233.00', 1, 1),
(4, 10, '潮流POLO衫', '79,85', '尺码:XML [+15.00]<br/>颜色:黑色', '200.00', '233.00', 2, 2),
(5, 19, '大气时尚女装', '145,151', '尺码:M<br/>颜色:白色', '111.00', '222.00', 1, 2),
(6, 12, '美女短裙', '96,102', '尺码:M<br/>颜色:黑色', '222.00', '233.00', 1, 2);

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '库存ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  `goods_number` mediumint(8) unsigned NOT NULL COMMENT '库存数量',
  `goods_attr` varchar(150) NOT NULL COMMENT '库存属性',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`id`, `goods_id`, `goods_number`, `goods_attr`) VALUES
(48, 19, 3, '145,151'),
(47, 20, 44, '154,161'),
(46, 20, 44, '153,161'),
(45, 20, 33, '152,160');

-- --------------------------------------------------------

--
-- 表的结构 `recpos`
--

CREATE TABLE IF NOT EXISTS `recpos` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '推荐位ID',
  `recname` varchar(30) NOT NULL COMMENT '推荐位名称',
  `rectype` tinyint(1) NOT NULL DEFAULT '1' COMMENT '推荐位类型：1商品2栏目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `recpos`
--

INSERT INTO `recpos` (`id`, `recname`, `rectype`) VALUES
(2, '新品上架', 1),
(3, '热卖商品', 1),
(4, '精品推荐', 1),
(5, '精品女装', 2),
(6, '精品男装', 2),
(7, '特价商品', 1);

-- --------------------------------------------------------

--
-- 表的结构 `recvalue`
--

CREATE TABLE IF NOT EXISTS `recvalue` (
  `valueid` mediumint(8) unsigned NOT NULL COMMENT '商品或栏目ID',
  `recid` mediumint(8) unsigned NOT NULL COMMENT '推荐位ID',
  `rectype` tinyint(1) NOT NULL COMMENT '推荐位类型'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `recvalue`
--

INSERT INTO `recvalue` (`valueid`, `recid`, `rectype`) VALUES
(10, 3, 1),
(9, 2, 1),
(11, 2, 1),
(19, 2, 1),
(12, 3, 1),
(12, 2, 1),
(10, 7, 1),
(13, 7, 1),
(13, 3, 1),
(20, 2, 1),
(14, 4, 1),
(14, 2, 1),
(11, 3, 1),
(15, 4, 1),
(15, 2, 1),
(16, 4, 1),
(16, 2, 1),
(17, 4, 1),
(17, 2, 1),
(18, 4, 1),
(18, 3, 1),
(18, 2, 1),
(18, 7, 1),
(13, 2, 1),
(10, 2, 1),
(9, 7, 1);

-- --------------------------------------------------------

--
-- 表的结构 `shrinfo`
--

CREATE TABLE IF NOT EXISTS `shrinfo` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `shr` varchar(30) NOT NULL COMMENT '姓名',
  `province` varchar(50) NOT NULL COMMENT '省',
  `city` varchar(50) NOT NULL COMMENT '市',
  `county` varchar(60) NOT NULL COMMENT '县',
  `adress` varchar(255) NOT NULL COMMENT '详细地址',
  `phone` varchar(11) NOT NULL COMMENT '联系电话',
  `mid` mediumint(8) unsigned NOT NULL COMMENT '会员ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '类型ID',
  `type_name` varchar(30) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `type`
--

INSERT INTO `type` (`id`, `type_name`) VALUES
(4, '服装');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
