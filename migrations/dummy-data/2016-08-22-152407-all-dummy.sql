
INSERT INTO `users` (`id`, `hash`, `registered_at`) VALUES
(1, '4cf9cad0853e207fc63c21424bcb4cf4fbe5fbee', NOW()),
(2, '8f74c34fd2258e5eff460a2dc99e1a9dfc193f97', NOW()),
(3, 'b12fa4c5c92c3e40eb83c54eee4fe367070e767d', NOW()),
(4, 'd5288a60c4b939bff1429434c0fa1d594f3f3189', NOW()),
(5, '3775c17ab895fe946d3f6ed8cf628e74f484eef5', NOW());

INSERT INTO `notes` (`content`, `created_at`, `user_id`) VALUES
('eur', NOW(), '1'),
('http://www.nytimes.com/2016/12/13/us/politics/russia-hack-election-dnc.html?_r=2', NOW(), '1'),
('buy mouse', NOW(), '1'),
('http://www.bbc.com/capital/story/20170105-open-offices-are-damaging-our-memories', NOW(), '3'),
('http://www.bbc.com/earth/story/20170110-despite-what-you-might-think-chickens-are-not-stupid', NOW(), '3');
