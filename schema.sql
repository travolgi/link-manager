-- CREATE DATABASE link_manager DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE link_manager;

-- ===================
-- 1) USERS
-- ===================
CREATE TABLE users(
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(50) NOT NULL UNIQUE,
	email VARCHAR(100) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===================
-- 2) BOARDS
-- ===================
CREATE TABLE boards(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	slug VARCHAR(100) NOT NULL,
	user_id INT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

	-- delete all user's boards if the user is deleted
	CONSTRAINT fk_boards_user
		FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

	-- make the board name and slug unique only for the same user
	CONSTRAINT uq_boards_user_name UNIQUE (user_id, name),
	CONSTRAINT un_boards_user_slug UNIQUE (user_id, slug)
) ENGINE=InnoDB;

-- index for query optimization
CREATE INDEX idx_boards_user ON boards(user_id);

-- ===================
-- 3) LINKS
-- ===================
CREATE TABLE links(
	id INT AUTO_INCREMENT PRIMARY KEY,
	title VARCHAR(100) NOT NULL,
	url VARCHAR(500) NOT NULL,
	description TEXT,
	board_id INT NULL,
	user_id INT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

	-- orphan links when their board is deleted 
	CONSTRAINT fk_links_board
		FOREIGN KEY (board_id) REFERENCES boards(id) ON DELETE SET NULL,
	-- delete all user's links if the user is deleted
	CONSTRAINT fk_links_user
		FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- index for query optimization
CREATE INDEX idx_links_board ON links(board_id);
CREATE INDEX idx_links_user ON links(user_id);
-- index optimization for full text search 
CREATE FULLTEXT INDEX ft_idx_links_title_desc ON links(title, description);

-- ===================
-- 4) TAGS
-- ===================
CREATE TABLE tags(
	id INT AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	slug VARCHAR(50) NOT NULL,
	user_id INT NOT NULL,
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

	-- delete all user's tags if the user is deleted
	CONSTRAINT fk_tags_user
		FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
	-- make the tag name and slug unique only for the same user
	CONSTRAINT uq_tags_user_name UNIQUE (user_id, name),
	CONSTRAINT uq_tags_user_slug UNIQUE (user_id, slug)
) ENGINE=InnoDB;

-- index for query optimization
CREATE INDEX idx_tags_user ON tags(user_id);

-- ===================
-- 5) LINK_TAGS (N:N)
-- ===================
CREATE TABLE link_tags(
	id INT AUTO_INCREMENT PRIMARY KEY,
	link_id INT NOT NULL,
	tag_id INT NOT NULL,

	-- delete all linktags if their link or a tag is deleted
	CONSTRAINT fk_linktags_link
		FOREIGN KEY (link_id) REFERENCES links(id) ON DELETE CASCADE,
	CONSTRAINT fk_linktags_tag
		FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE,

	-- make the link tag unique
	CONSTRAINT uq_link_tag UNIQUE (link_id, tag_id)
) ENGINE=InnoDB;

-- index for query optimization
CREATE INDEX idx_linktags_link ON link_tags(link_id);
CREATE INDEX idx_linktags_tag ON link_tags(tag_id);