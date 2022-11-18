-- Assignment 2
--
-- Startup SQL source
--
-- Add additional tables as required and feel free to modify these
-- startup up tables as you see fit
--
-- List of aircraft types in the fleet. The assignment brief states
-- there are 2 Cirrus jets and 2 Honda jets. Consider how this
-- can be accommodated in the database
CREATE TABLE Aircraft
(
    craftID  VARCHAR(3)  NOT NULL,
    model    VARCHAR(55) NOT NULL,
    capacity INT         NOT NULL, -- max number of passengers
    rangenmi FLOAT       NOT NULL, -- range in nmi
    cruisekn FLOAT       NOT NULL, -- cruise speed in knots
    PRIMARY KEY (craftID)
);

INSERT INTO Aircraft
VALUES ('A01', 'SyberJet SJ30i', 6, 1350, 470);
INSERT INTO Aircraft
VALUES ('A02', 'Cirrus SF50', 4, 1171, 342);
INSERT INTO Aircraft
VALUES ('A03', 'HondaJet Elite', 5, 2205, 408);

-- List of destinations by airport
CREATE TABLE Destinations
(
    code    VARCHAR(4)  NOT NULL, -- 4 letter ICAO code
    tz      VARCHAR(8)  NOT NULL,
    airport VARCHAR(55) NOT NULL, -- name of airport
    region  VARCHAR(55) NOT NULL, -- region served
    PRIMARY KEY (code)
);
INSERT INTO Destinations
VALUES ('NZNE', '12:00:00', 'Dairy Flat Airport', 'North Shore');
INSERT INTO Destinations
VALUES ('YSSY', '10:00:00', 'Sydney Kingsford Smith Airport', 'Sydney');
INSERT INTO Destinations
VALUES ('NZRO', '12:00:00', 'Rotorua Aiport', 'Rotorua');
INSERT INTO Destinations
VALUES ('NZCI', '12:45:00', 'Tuuta Aiport', 'Chatham Islands');
INSERT INTO Destinations
VALUES ('NZGB', '12:00:00', 'Claris Aerodrome', 'Great Barrier Island');
INSERT INTO Destinations
VALUES ('NZTL', '12:00:00', 'Lake Tekapo Airport', 'Mackenzie District');

-- List of operating routes. This information applies in either
-- direction between the points
CREATE TABLE Routes
(
    routeID  VARCHAR(3) NOT NULL,
    point1   VARCHAR(4) NOT NULL,
    point2   VARCHAR(4) NOT NULL,
    distance FLOAT      NOT NULL, -- separation distance in nmi
    PRIMARY KEY (routeID),
    FOREIGN KEY (point1) REFERENCES Destinations (code),
    FOREIGN KEY (point2) REFERENCES Destinations (code)
);
INSERT INTO Routes
VALUES ('R01', 'NZNE', 'YSSY', 1164);
INSERT INTO Routes
VALUES ('R02', 'NZNE', 'NZRO', 137);
INSERT INTO Routes
VALUES ('R03', 'NZNE', 'NZCI', 581);
INSERT INTO Routes
VALUES ('R04', 'NZNE', 'NZGB', 54);
INSERT INTO Routes
VALUES ('R05', 'NZNE', 'NZTL', 472);

-- my tables

CREATE TABLE Schedules
(
    scheduleID VARCHAR(100) NOT NULL PRIMARY KEY,
    aircraftID VARCHAR(100) NOT NULL,
    routeID    VARCHAR(100) NOT NULL,
    time       VARCHAR(100) NOT NULL,
    timezone   VARCHAR(100) NOT NULL,
    minutes    int          NOT NULL,
    isReturn   BOOLEAN      NOT NULL,
    price      int          NOT NULL,
    FOREIGN KEY (routeID) REFERENCES Routes (routeID),
    FOREIGN KEY (aircraftID) REFERENCES Aircraft (craftID)
);

CREATE TABLE ScheduleWeekdays
(
    ID         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    scheduleID VARCHAR(100),
    weekDay    int,
    FOREIGN KEY (scheduleID) REFERENCES Schedules (scheduleID)
);

INSERT INTO Schedules
VALUES ('1', 'A01', 'R01', '12:00 pm', 'NZST', 240, FALSE, 400);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('1', 5);

INSERT INTO Schedules
VALUES ('2', 'A01', 'R01', '09:00 am', 'NZST', 240, TRUE, 400);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('2', 0);

INSERT INTO Schedules
VALUES ('3', 'A02', 'R02', '9am', '', 50, FALSE, 80);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('3', 1);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('3', 2);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('3', 3);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('3', 4);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('3', 5);

INSERT INTO Schedules
VALUES ('4', 'A02', 'R02', '11am', '', 50, TRUE, 80);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('4', 1);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('4', 2);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('4', 3);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('4', 4);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('4', 5);

INSERT INTO Schedules
VALUES ('5', 'A02', 'R02', '5pm', '', 50, FALSE, 80);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('5', 1);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('5', 2);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('5', 3);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('5', 4);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('5', 5);

INSERT INTO Schedules
VALUES ('6', 'A02', 'R02', '7pm', '', 50, TRUE, 80);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('6', 1);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('6', 2);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('6', 3);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('6', 4);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('6', 5);


INSERT INTO Schedules
VALUES ('7', 'A02', 'R04', '10am', '', 240, FALSE, 400);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('7', 1);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('7', 3);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('7', 5);

INSERT INTO Schedules
VALUES ('8', 'A02', 'R04', '10am', '', 240, TRUE, 400);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('8', 2);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('8', 5);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('8', 6);

INSERT INTO Schedules
VALUES ('9', 'A03', 'R03', '10am', '', 120, FALSE, 300);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('9', 2);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('9', 5);

INSERT INTO Schedules
VALUES ('10', 'A03', 'R03', '3pm', '', 120, TRUE, 300);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('10', 3);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('10', 6);

INSERT INTO Schedules
VALUES ('11', 'A03', 'R05', '10am', '', 60, FALSE, 200);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('11', 1);

INSERT INTO Schedules
VALUES ('12', 'A03', 'R05', '10am', '', 60, TRUE, 200);
INSERT INTO ScheduleWeekdays (scheduleID, weekDay)
VALUES ('12', 5);


CREATE TABLE Users
(
    email    VARCHAR(200) NOT NULL PRIMARY KEY,
    name     VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE Receipt
(
    ID         INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    email      VARCHAR(100)    NOT NULL,
    scheduleID VARCHAR(100)    NOT NULL,
    date       date            NOT NULL,
    seat       int             not null,
    FOREIGN KEY (email) REFERENCES Users (email),
    FOREIGN KEY (scheduleID) REFERENCES Schedules (scheduleID)
);
