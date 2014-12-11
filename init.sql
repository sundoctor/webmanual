DROP TABLE IF EXISTS topic;
CREATE TABLE topic (
    topic_id INTEGER PRIMARY KEY,
    topic_pid INTEGER DEFAULT 0 NOT NULL,
    topic_name VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS content;
CREATE TABLE content (
    content_id INTEGER PRIMARY KEY,
    content_topic_id INTEGER NOT NULL,
    content_title VARCHAR(100) NOT NULL,
    content_text TEXT
);
CREATE INDEX idx_content_title ON content (content_title);

DROP TABLE IF EXISTS files;
CREATE TABLE files (
    file_id INTEGER PRIMARY KEY,
    file_path VARCHAR(100) NOT NULL,
    file_type VARCHAR(20) NOT NULL,
    file_name VARCHAR(100)
);

INSERT INTO topic (topic_pid, topic_name) VALUES (0, 'First Topic');
INSERT INTO topic (topic_pid, topic_name) VALUES (1, 'Second Topic');
INSERT INTO topic (topic_pid, topic_name) VALUES (0, 'Third Topic');

INSERT INTO content (content_topic_id, content_title) VALUES (1, 'Text subject A');
INSERT INTO content (content_topic_id, content_title) VALUES (1, 'Text subject B');
INSERT INTO content (content_topic_id, content_title) VALUES (2, 'Text subject C');
INSERT INTO content (content_topic_id, content_title) VALUES (2, 'Text subject D');

