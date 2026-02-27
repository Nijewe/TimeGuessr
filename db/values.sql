
INSERT INTO Images(path, position, correct_year, info, hint)
VALUES
-- 1. Zurich Marriott Hotel
(
  'https://upload.wikimedia.org/wikipedia/commons/a/af/Zurich_Marriott_Hotel.jpg',
  ST_GeomFromText('POINT(47.3791 8.5387)', 4326),
  2019,
  'Zurich Marriott Hotel on the river Limmat',
  'Zurich'
),
-- 2. Brooklyn Navy Yard, 1918
(
  'https://upload.wikimedia.org/wikipedia/commons/9/90/Navy_Yard%2C_Brooklyn._New_York._1918_-_NH_117794.jpg',
  ST_GeomFromText('POINT(40.6984 -73.9766)', 4326),
  1918,
  'Aerial view of the Brooklyn Navy Yard on the East River, Wallabout Bay',
  'Brooklyn'
),
-- 3. Rotterdam, 2000
(
  'https://upload.wikimedia.org/wikipedia/commons/1/15/Rotterdam_02-07-2000_52.jpg',
  ST_GeomFromText('POINT(51.9200 4.4883)', 4326),
  2000,
  'Rotterdam city center near Blaak station',
  'UEFA Euro'
),
-- 4. SpaceX CRS-14 Falcon 9, 2018
(
  'https://upload.wikimedia.org/wikipedia/commons/6/69/SpaceX_CRS-14_Falcon_9_rocket_lifts_off_%28KSC-20180402-PH_AWG01_0023%29.jpg',
  ST_GeomFromText('POINT(28.6080 -80.6040)', 4326),
  2018,
  'SpaceX CRS-14 Falcon 9 rocket liftoff from Launch Complex 39A, Kennedy Space Center',
  'Cape Canaveral'
),
-- 5. Paramount Theatre Boston
(
  'https://upload.wikimedia.org/wikipedia/commons/2/27/Paramount_Theatre_Boston.jpg',
  ST_GeomFromText('POINT(42.3537 -71.0628)', 4326),
  1932,
  'Paramount Theatre on Washington Street, Boston',
  'Boston'
),
-- 6. Taj Mahal, 2004
(
  'https://upload.wikimedia.org/wikipedia/commons/c/c8/Taj_Mahal_in_March_2004.jpg',
  ST_GeomFromText('POINT(27.1751 78.0421)', 4326),
  2004,
  'The Taj Mahal mausoleum on the banks of the Yamuna River, Agra',
  'India'
),
-- 7. Victoria Falls, 2018
(
  'https://upload.wikimedia.org/wikipedia/commons/8/81/Cataratas_Victoria%2C_Zambia-Zimbabue%2C_2018-07-27%2C_DD_30-34_PAN.jpg',
  ST_GeomFromText('POINT(-17.9243 25.8572)', 4326),
  2018,
  'Panoramic view of Victoria Falls on the Zambezi River, on the border of Zambia and Zimbabwe',
  'Africa'
),
-- 8. FIFA World Cup 2014 Opening Ceremony
(
  'https://upload.wikimedia.org/wikipedia/commons/6/6a/The_opening_ceremony_of_the_FIFA_World_Cup_2014_17.jpg',
  ST_GeomFromText('POINT(-23.5452 -46.4731)', 4326),
  2014,
  'Opening ceremony of the FIFA World Cup 2014 at Arena Corinthians (Arena de São Paulo)',
  'Brazil'
),
-- 9. Shaolin Temple Great Buddha Hall, 2024
(
  'https://upload.wikimedia.org/wikipedia/commons/1/1f/20241103_The_Great_Buddha%27s_Hall%2C_Shaolin_Temple.jpg',
  ST_GeomFromText('POINT(34.5002 112.9093)', 4326),
  2024,
  'The Great Buddha Hall at the Shaolin Temple, birthplace of Chan Buddhism and Shaolin Kung Fu',
  'Buddha'
),
-- 10. Moscow Victory Day Parade Rehearsal, 2012
(
  'https://upload.wikimedia.org/wikipedia/commons/e/eb/Moscow_2012_Victory_Day_Parade_Rehearsal%2C_Army%2C_Russia.jpg',
  ST_GeomFromText('POINT(55.7539 37.6208)', 4326),
  2012,
  'Military parade rehearsal on Red Square for the 2012 Victory Day, Moscow',
  'Victory Day'
);