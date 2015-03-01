DROP TABLE IF EXISTS topic;
CREATE TABLE topic (
    topic_id INTEGER PRIMARY KEY,
    topic_pid INTEGER DEFAULT 0 NOT NULL,
    topic_seq INTEGER DEFAULT 0 NOT NULL,
    topic_name VARCHAR(100) NOT NULL
);

DROP TABLE IF EXISTS content;
CREATE TABLE content (
    content_id INTEGER PRIMARY KEY,
    content_topic_id INTEGER,
    content_seq INTEGER DEFAULT 0 NOT NULL,
    content_title VARCHAR(100) NOT NULL,
    content_text TEXT,
    content_format VARCHAR(5) NOT NULL DEFAULT 'plain',  -- html/tags/wiki
    FOREIGN KEY(content_topic_id) REFERENCES topic(topic_id)
);
CREATE INDEX idx_content_title ON content (content_title);

DROP TABLE IF EXISTS files;
CREATE TABLE files (
    file_id INTEGER PRIMARY KEY,
    file_path VARCHAR(100) NOT NULL,
    file_type VARCHAR(20) NOT NULL,
    file_name VARCHAR(100) NOT NULL,
    file_size INTEGER NOT NULL DEFAULT 0,
    file_sx INTEGER NOT NULL DEFAULT 0,
    file_sy INTEGER NOT NULL DEFAULT 0
);

INSERT INTO topic (topic_pid, topic_seq, topic_name) VALUES (0, 1, 'First Topic');
INSERT INTO topic (topic_pid, topic_seq, topic_name) VALUES (0, 2, 'Second Topic');
INSERT INTO topic (topic_pid, topic_seq, topic_name) VALUES (0, 3, 'Third Topic');

INSERT INTO content (content_topic_id, content_seq, content_title) VALUES (1, 1, 'Text subject A');
INSERT INTO content (content_topic_id, content_seq, content_title) VALUES (1, 2, 'Text subject B');
INSERT INTO content (content_topic_id, content_seq, content_title) VALUES (2, 1, 'Text subject C');
INSERT INTO content (content_topic_id, content_seq, content_title) VALUES (2, 2, 'Text subject D');

