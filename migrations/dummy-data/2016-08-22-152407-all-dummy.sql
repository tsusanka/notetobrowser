
INSERT INTO `users` (`id`, `hash`, `registered_at`) VALUES
(1, 'ec9887cc341ab3f5bf5e6a14ff56c9c5aeb2b4b8d99557e406a456e4e029fd1e', NOW()),
(2, 'f30c2afefcc4a8adf7ac7a0db082e298f978911e2cae4e0b4aa36103399e69f3', NOW()),
(3, '0263829989b6fd954f72baaf2fc64bc2e2f01d692d4de72986ea808f6e99813f', NOW()),
(4, 'ff304d19e8233ac9117fef9eb247a8fb4751f5f6a6237a41ccc13440f8c6cda4', NOW()),
(5, '98a3818f67fc20fe9af17bebf32ce482e43a32ab3c979e48849efcad8b69ac13', NOW());

INSERT INTO `notes` (`content`, `created_at`, `user_id`) VALUES
('eur', NOW(), '1'),
('http://www.nytimes.com/2016/12/13/us/politics/russia-hack-election-dnc.html?_r=2', NOW(), '1'),
('buy mouse', NOW(), '1'),
('http://www.bbc.com/capital/story/20170105-open-offices-are-damaging-our-memories', NOW(), '3'),
('http://www.bbc.com/earth/story/20170110-despite-what-you-might-think-chickens-are-not-stupid', NOW(), '3');
