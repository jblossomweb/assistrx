ALTER TABLE `songs` 
ADD COLUMN `song_genre` VARCHAR(55) NULL AFTER `song_artist`;


CREATE TABLE `genres` (
  `genre_name` VARCHAR(55) NOT NULL,
  `genre_desc` VARCHAR(255) NULL,
  `genre_url` VARCHAR(255) NULL,
  `chart_color` VARCHAR(7) NULL,
  `chart_highlight` VARCHAR(7) NULL,
  PRIMARY KEY (`genre_name`));
