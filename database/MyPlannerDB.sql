-- --------------------------------------------------------------------------------
-- Kenneth Otero
-- "My Planner"
-- Abstract: Database
-- Date Started: May 10, 2022
-- --------------------------------------------------------------------------------
USE dbsql; -- Use our local database

-- --------------------------------------------------------------------------------
-- Drop Tables
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS TAssignments;
DROP TABLE IF EXISTS TCourses;
DROP TABLE IF EXISTS TStatuses;
DROP TABLE IF EXISTS TSemesters;
DROP TABLE IF EXISTS TUsers;

-- --------------------------------------------------------------------------------
-- Drop Audit Tables
-- --------------------------------------------------------------------------------
DROP TABLE IF EXISTS Z_TAssignments;
DROP TABLE IF EXISTS Z_TCourses;
DROP TABLE IF EXISTS Z_TSemesters;
DROP TABLE IF EXISTS Z_TUsers;

-- --------------------------------------------------------------------------------
-- Drop Stored Procedures
-- --------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS uspAddUser;
DROP PROCEDURE IF EXISTS uspUpdateUser;
DROP PROCEDURE IF EXISTS uspAddCourse;
DROP PROCEDURE IF EXISTS uspUpdateCourse;
DROP PROCEDURE IF EXISTS uspAddSemester;
DROP PROCEDURE IF EXISTS uspUpdateSemester;
DROP PROCEDURE IF EXISTS uspAddAssignment;
DROP PROCEDURE IF EXISTS uspUpdateAssignment;
DROP PROCEDURE IF EXISTS uspLoggedIn;
DROP PROCEDURE IF EXISTS uspUnfinishedAssignments;
DROP PROCEDURE IF EXISTS uspFinishedAssignments;
DROP PROCEDURE IF EXISTS uspCurrentCourses;
DROP PROCEDURE IF EXISTS uspActiveSemester;
DROP PROCEDURE IF EXISTS uspDeleteSemester;
DROP PROCEDURE IF EXISTS uspResetPassword;
DROP PROCEDURE IF EXISTS uspDeleteCourse;
DROP PROCEDURE IF EXISTS uspDeleteAssignment;
DROP PROCEDURE IF EXISTS uspMonthlyAssignments;

-- --------------------------------------------------------------------------------
-- Create Tables
-- --------------------------------------------------------------------------------
CREATE TABLE TUsers (
	intUserID			INTEGER AUTO_INCREMENT	NOT NULL,
    strName				VARCHAR(250)			NOT NULL,
    strEmail			VARCHAR(250)			NOT NULL,
    strPassword			VARCHAR(250)			NOT NULL,
    strSecurity			VARCHAR(250)			NOT NULL,
    intCurrentSemester	INTEGER,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT TUsers_UQ UNIQUE (strEmail),
    CONSTRAINT TUsers_PK PRIMARY KEY (intUserID)
);

CREATE TABLE TSemesters (
	intSemesterID		INTEGER AUTO_INCREMENT	NOT NULL,
    strSemester			VARCHAR(250)			NOT NULL,
    intYear				INTEGER					NOT NULL,
    dtmStartDate		DATETIME				NOT NULL,
    dtmEndDate			DATETIME				NOT NULL,
    intUserID			INTEGER					NOT NULL,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT TSemesters_PK PRIMARY KEY (intSemesterID)
);

CREATE TABLE TCourses (
	intCourseID			INTEGER AUTO_INCREMENT 	NOT NULL,
    strCourse			VARCHAR(250)			NOT NULL,	
    strCourseNumber		VARCHAR(250)			NOT NULL,
    strInstructor		VARCHAR(250)			NOT NULL,
    dtmStart			TIME					NOT NULL,
    dtmEnd				TIME					NOT NULL,
    intSemesterID		INTEGER					NOT NULL,
    intUserID			INTEGER					NOT NULL,
    blnMonday			BOOLEAN,
    blnTuesday			BOOLEAN,
    blnWednesday		BOOLEAN,
    blnThursday			BOOLEAN,
    blnFriday			BOOLEAN,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT TCourses_PK PRIMARY KEY (intCourseID)
);

CREATE TABLE TStatuses (
	intStatusID			INTEGER AUTO_INCREMENT	NOT NULL,
    strStatus			VARCHAR(250)			NOT NULL,
    CONSTRAINT TStatuses PRIMARY KEY (intStatusID)
);

CREATE TABLE TAssignments (
	intAssignmentID		INTEGER AUTO_INCREMENT	NOT NULL,
    strAssignment		VARCHAR(250)			NOT NULL,
    strDetails			TEXT					NOT NULL,
    dtmDueDate			DATETIME				NOT NULL,
    intStatusID			INTEGER					NOT NULL,
    intProgress			INTEGER					NOT NULL,
    intCourseID			INTEGER					NOT NULL,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT TAssignments_PK PRIMARY KEY (intAssignmentID)
);

-- --------------------------------------------------------------------------------
-- Create Audit Tables
-- --------------------------------------------------------------------------------
CREATE TABLE Z_TUsers (
	intUserAuditID		INTEGER AUTO_INCREMENT	NOT NULL,
    intUserID			INTEGER					NOT NULL,
    strName				VARCHAR(250)			NOT NULL,
    strEmail			VARCHAR(250)			NOT NULL,
    strPassword			VARCHAR(250)			NOT NULL,
    strSecurity			VARCHAR(250)			NOT NULL,
    intCurrentSemester	INTEGER,
    strUpdatedBy		VARCHAR(128)			NOT NULL,
	dtmUpdatedOn		DATETIME				NOT NULL,
	strAction			VARCHAR(1)				NOT NULL,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT Z_TUsers_PK PRIMARY KEY (intUserAuditID)
);

CREATE TABLE Z_TSemesters (
	intSemesterAuditID	INTEGER	AUTO_INCREMENT	NOT NULL,
    intSemesterID		INTEGER 				NOT NULL,
    strSemester			VARCHAR(250)			NOT NULL,
    intYear				INTEGER					NOT NULL,
    dtmStartDate		DATETIME				NOT NULL,
    dtmEndDate			DATETIME				NOT NULL,
    intUserID			INTEGER					NOT NULL,
    strUpdatedBy		VARCHAR(128)			NOT NULL,
	dtmUpdatedOn		DATETIME				NOT NULL,
	strAction			VARCHAR(1)				NOT NULL,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT Z_TSemesters_PK PRIMARY KEY (intSemesterAuditID)
);

CREATE TABLE Z_TCourses (
	intCourseAuditID	INTEGER AUTO_INCREMENT 	NOT NULL,
	intCourseID			INTEGER 			 	NOT NULL,
    strCourse			VARCHAR(250)			NOT NULL,	
    strCourseNumber		VARCHAR(250)			NOT NULL,
    strInstructor		VARCHAR(250)			NOT NULL,
    dtmStart			TIME					NOT NULL,
    dtmEnd				TIME					NOT NULL,
    intSemesterID		INTEGER					NOT NULL,
    intUserID			INTEGER					NOT NULL,
    blnMonday			BOOLEAN,
    blnTuesday			BOOLEAN,
    blnWednesday		BOOLEAN,
    blnThursday			BOOLEAN,
    blnFriday			BOOLEAN,
    strUpdatedBy		VARCHAR(128)			NOT NULL,
	dtmUpdatedOn		DATETIME				NOT NULL,
	strAction			VARCHAR(1)				NOT NULL,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT Z_TCourses_PK PRIMARY KEY (intCourseAuditID)
);

CREATE TABLE Z_TAssignments (
	intAssignmentAuditID INTEGER AUTO_INCREMENT	NOT NULL,
	intAssignmentID		INTEGER 				NOT NULL,
    strAssignment		VARCHAR(250)			NOT NULL,
    strDetails			TEXT					NOT NULL,
    dtmDueDate			DATETIME				NOT NULL,
    intStatusID			INTEGER					NOT NULL,
    intProgress			INTEGER					NOT NULL,
    intCourseID			INTEGER					NOT NULL,
    strUpdatedBy		VARCHAR(128)			NOT NULL,
	dtmUpdatedOn		DATETIME				NOT NULL,
	strAction			VARCHAR(1)				NOT NULL,
    strModified_Reason	VARCHAR(250),
    CONSTRAINT Z_TAssignments_PK PRIMARY KEY (intAssignmentAuditID)
);

-- --------------------------------------------------------------------------------
-- Create Triggers
-- --------------------------------------------------------------------------------
-- Create trigger for inserting on TUsers
DELIMITER //
CREATE TRIGGER tr_InsertUsers 
AFTER INSERT ON TUsers
FOR EACH ROW
BEGIN
	-- Set strAction to Insert (I)
    SET @strAction = 'I';
    INSERT INTO Z_TUsers (intUserID, strName, strEmail, strPassword, strSecurity, intCurrentSemester, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 intUserID
		,strName
		,strEmail
		,strPassword
		,strSecurity
		,intCurrentSemester
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TUsers WHERE intUserID = NEW.intUserID;
END //
DELIMITER ;

-- Create trigger for updating on TUsers
DELIMITER //
CREATE TRIGGER tr_UpdateUsers 
AFTER UPDATE ON TUsers
FOR EACH ROW
BEGIN
	-- Set strAction to Update (U)
    SET @strAction = 'U';
    INSERT INTO Z_TUsers (intUserID, strName, strEmail, strPassword, strSecurity, intCurrentSemester, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 NEW.intUserID
		,NEW.strName
		,NEW.strEmail
		,NEW.strPassword
		,NEW.strSecurity
		,NEW.intCurrentSemester
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TUsers WHERE intUserID = NEW.intUserID;
END //
DELIMITER ;

-- Create trigger for deleting on TUsers
DELIMITER //
CREATE TRIGGER tr_DeleteUsers 
AFTER DELETE ON TUsers
FOR EACH ROW
BEGIN
	-- Set strAction to Delete (D)
    SET @strAction = 'D';
    INSERT INTO Z_TUsers (intUserID, strName, strEmail, strPassword, strSecurity, intCurrentSemester, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    VALUES	(OLD.intUserID
			,OLD.strName
			,OLD.strEmail
			,OLD.strPassword
			,OLD.strSecurity
			,OLD.intCurrentSemester
			,CURRENT_USER()
			,NOW()
			,@strAction
			,OLD.strModified_Reason);
END //
DELIMITER ;

-- Create trigger for inserting on TSemesters
DELIMITER //
CREATE TRIGGER tr_InsertSemesters
AFTER INSERT ON TSemesters
FOR EACH ROW
BEGIN
	-- Set strAction to Insert (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TSemesters (intSemesterID, strSemester, intYear, dtmStartDate, dtmEndDate, intUserID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 intSemesterID
		,strSemester
		,intYear
		,dtmStartDate
		,dtmEndDate
		,intUserID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TSemesters WHERE intSemesterID = NEW.intSemesterID;
END //
DELIMITER ;

-- Create trigger for updating on TSemesters 
DELIMITER //
CREATE TRIGGER tr_UpdateSemesters
AFTER UPDATE ON TSemesters
FOR EACH ROW
BEGIN
	-- Set strAction to Update (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TSemesters (intSemesterID, strSemester, intYear, dtmStartDate, dtmEndDate, intUserID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 NEW.intSemesterID
		,NEW.strSemester
		,NEW.intYear
		,NEW.dtmStartDate
		,NEW.dtmEndDate
		,NEW.intUserID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TSemesters WHERE intSemesterID = NEW.intSemesterID;
END //
DELIMITER ;

-- Create trigger for deleting on TSemesters
DELIMITER //
CREATE TRIGGER tr_DeleteSemesters
AFTER DELETE ON TSemesters
FOR EACH ROW
BEGIN
	-- Set strAction to Delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TSemesters (intSemesterID, strSemester, intYear, dtmStartDate, dtmEndDate, intUserID, strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    VALUES	(OLD.intSemesterID
			,OLD.strSemester
			,OLD.intYear
			,OLD.dtmStartDate
			,OLD.dtmEndDate
			,OLD.intUserID
			,CURRENT_USER()
			,NOW()
			,@strAction
			,OLD.strModified_Reason);
END //
DELIMITER ;

-- Create trigger for inserting on TCourses
DELIMITER //
CREATE TRIGGER tr_InsertCourses
AFTER INSERT ON TCourses
FOR EACH ROW
BEGIN
	-- Set strAction to Insert (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TCourses (intCourseID, strCourse, strCourseNumber, strInstructor, dtmStart, dtmEnd, intSemesterID, intUserID, 
							blnMonday, blnTuesday, blnWednesday, blnThursday, blnFriday,
							strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 intCourseID
		,strCourse
		,strCourseNumber
		,strInstructor
		,dtmStart
		,dtmEnd
        ,intSemesterID
        ,intUserID
        ,blnMonday
        ,blnTuesday
        ,blnWednesday
        ,blnThursday
        ,blnFriday
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TCourses WHERE intCourseID = NEW.intCourseID;
END //
DELIMITER ;

-- Create trigger for updating on TCourses
DELIMITER //
CREATE TRIGGER tr_UpdateCourses
AFTER UPDATE ON TCourses
FOR EACH ROW
BEGIN
	-- Set strAction to Update (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TCourses (intCourseID, strCourse, strCourseNumber, strInstructor, dtmStart, dtmEnd, intSemesterID, intUserID, 
							blnMonday, blnTuesday, blnWednesday, blnThursday, blnFriday,
							strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 NEW.intCourseID
		,NEW.strCourse
		,NEW.strCourseNumber
		,NEW.strInstructor
		,NEW.dtmStart
		,NEW.dtmEnd
        ,NEW.intSemesterID
        ,NEW.intUserID
        ,NEW.blnMonday
        ,NEW.blnTuesday
        ,NEW.blnWednesday
        ,NEW.blnThursday
        ,NEW.blnFriday
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TCourses WHERE intCourseID = NEW.intCourseID;
END //
DELIMITER ;

-- Create trigger for deleting on TCourses
DELIMITER //
CREATE TRIGGER tr_DeleteCourses
AFTER DELETE ON TCourses
FOR EACH ROW
BEGIN
	-- Set strAction to Delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TCourses (intCourseID, strCourse, strCourseNumber, strInstructor, dtmStart, dtmEnd, intSemesterID, intUserID, 
							blnMonday, blnTuesday, blnWednesday, blnThursday, blnFriday,
							strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    VALUES  (OLD.intCourseID
			,OLD.strCourse
			,OLD.strCourseNumber
			,OLD.strInstructor
			,OLD.dtmStart
			,OLD.dtmEnd
			,OLD.intSemesterID
			,OLD.intUserID
			,OLD.blnMonday
			,OLD.blnTuesday
			,OLD.blnWednesday
			,OLD.blnThursday
			,OLD.blnFriday
			,CURRENT_USER()
			,NOW()
			,@strAction
			,OLD.strModified_Reason);
END //
DELIMITER ;

-- Create trigger for inserting on TAssignments
DELIMITER //
CREATE TRIGGER tr_InsertAssignments
AFTER INSERT ON TAssignments
FOR EACH ROW
BEGIN
	-- Set strAction to Insert (I)
    SET @strAction = 'I';
    
    INSERT INTO Z_TAssignments (intAssignmentID, strAssignment, strDetails, dtmDueDate, intStatusID, intProgress, intCourseID,
								strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 intAssignmentID
		,strAssignment
		,strDetails
		,dtmDueDate
		,intStatusID
		,intProgress
        ,intCourseID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,strModified_Reason
	FROM TAssignments WHERE intAssignmentID = NEW.intAssignmentID;
END //
DELIMITER ;

-- Create trigger for updating on TAssignments
DELIMITER //
CREATE TRIGGER tr_UpdateAssignments
AFTER UPDATE ON TAssignments
FOR EACH ROW
BEGIN
	-- Set strAction to Update (U)
    SET @strAction = 'U';
    
    INSERT INTO Z_TAssignments (intAssignmentID, strAssignment, strDetails, dtmDueDate, intStatusID, intProgress, intCourseID,
								strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    SELECT 
		 NEW.intAssignmentID
		,NEW.strAssignment
		,NEW.strDetails
		,NEW.dtmDueDate
		,NEW.intStatusID
		,NEW.intProgress
        ,NEW.intCourseID
		,CURRENT_USER()
		,NOW()
		,@strAction
		,NEW.strModified_Reason
	FROM TAssignments WHERE intAssignmentID = NEW.intAssignmentID;
END //
DELIMITER ;

-- Create trigger for deleting on TAssignments
DELIMITER //
CREATE TRIGGER tr_DeleteAssignments
AFTER DELETE ON TAssignments
FOR EACH ROW
BEGIN
	-- Set strAction to Delete (D)
    SET @strAction = 'D';
    
    INSERT INTO Z_TAssignments (intAssignmentID, strAssignment, strDetails, dtmDueDate, intStatusID, intProgress, intCourseID,
								strUpdatedBy, dtmUpdatedOn, strAction, strModified_Reason)
    VALUES 	(OLD.intAssignmentID
			,OLD.strAssignment
			,OLD.strDetails
			,OLD.dtmDueDate
			,OLD.intStatusID
			,OLD.intProgress
			,OLD.intCourseID
			,CURRENT_USER()
			,NOW()
			,@strAction
			,OLD.strModified_Reason);
END //
DELIMITER ;

-- --------------------------------------------------------------------------------
-- Identify and Create Foreign Keys
-- --------------------------------------------------------------------------------
--
-- #	Child								Parent						Column(s)
-- -	-----								------						---------
-- 1	TCourses							TSemesters					intSemesterID
-- 2	TCourses							TUsers						intUserID
-- 3	TAssignments						TCourses					intCourseID
-- 4	TAssignments						TStatuses					intStatusID
-- 5	TSemesters							TUsers						intUserID

-- 1
ALTER TABLE TCourses ADD CONSTRAINT TCourses_TSemesters_FK
FOREIGN KEY (intSemesterID) REFERENCES TSemesters (intSemesterID) ON DELETE CASCADE;

-- 2
ALTER TABLE TCourses ADD CONSTRAINT TCourses_TUsers_FK
FOREIGN KEY (intUserID) REFERENCES TUsers (intUserID);

-- 3
ALTER TABLE TAssignments ADD CONSTRAINT TAssignments_TCourses_FK
FOREIGN KEY (intCourseID) REFERENCES TCourses (intCourseID) ON DELETE CASCADE;

-- 4
ALTER TABLE TAssignments ADD CONSTRAINT TAssignments_TStatuses_FK
FOREIGN KEY (intStatusID) REFERENCES TStatuses (intStatusID);

-- 5
ALTER TABLE TSemesters ADD CONSTRAINT TSemesters_TUsers_FK
FOREIGN KEY (intUserID) REFERENCES TUsers (intUserID);

-- --------------------------------------------------------------------------------
-- Insert Data
-- --------------------------------------------------------------------------------
INSERT INTO TStatuses (strStatus)
VALUES	('Unfinished'),
		('Finished');
        
INSERT INTO TUsers (strName, strEmail, strPassword, strSecurity, intCurrentSemester)
VALUES	('Kenneth Otero', 'bloodhound752@gmail.com', 'password', 'New York', 1),
		('Lucas White', 'test@gmail.com', 'password', 'New York', 1);

INSERT INTO TSemesters (strSemester, intYear, dtmStartDate, dtmEndDate, intUserID)
VALUES	('Spring', 2022, '2022-05-02', '2022-05-21',  1),
		('Summer', 2022, '2022-05-02', '2022-05-21',1),
        ('Fall', 2022, '2022-05-02', '2022-05-21', 1);
        
INSERT INTO TCourses (strCourse, strCourseNumber, strInstructor, dtmStart, dtmEnd, intSemesterID, intUserID)
VALUES	('Web App Development 1', 'IT 117', 'Bob Nields', '11:12:00', '11:50:00', 1, 1),
		('CPDM Capstone', 'CPDM 290', 'Bob Nields', '11:12:00', '11:50:00', 1, 1),
		('Managerial Accounting', 'ACC 102', 'Stani Kantcheva', '11:12:00', '11:50:00', 1, 1);
                
INSERT INTO TAssignments (strAssignment, strDetails, dtmDueDate, intStatusID, intProgress, intCourseID)
VALUES	('Final Exam', 'Nothing', '2022-05-02', 1, 0, 3),
		('Final Project', 'Nothing', '2022-05-02', 1, 0, 2),
        ('Final Project', 'Nothing', '2022-05-02', 1, 0, 1);
       
-- --------------------------------------------------------------------------------
-- Create Stored Procedures
-- --------------------------------------------------------------------------------
-- Add a user
DELIMITER //
CREATE PROCEDURE uspAddUser (
	IN p_strName		VARCHAR(250),
	IN p_strEmail		VARCHAR(250),
    IN p_strPassword	VARCHAR(250),
    IN p_strSecurity	VARCHAR(250),
    IN p_strSemester 	VARCHAR(250),
    IN p_intYear		INTEGER,
    OUT p_intUserID		INTEGER,
    OUT p_intSemesterID	INTEGER
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert new user
	INSERT INTO TUsers (strName, strEmail, strPassword, strSecurity)
    VALUES	(p_strName, p_strEmail, p_strPassword, p_strSecurity);
    
    -- Get latest PK
    SELECT intUserID INTO p_intUserID FROM TUsers ORDER BY intUserID DESC LIMIT 1;
    
    -- Internal intUserID variable
    SET @UserID = 0;    
    SELECT intUserID INTO @UserID FROM TUsers ORDER BY intUserID DESC LIMIT 1;
    
    -- Add new semester
    INSERT INTO TSemesters (strSemester, intYear, intUserID)
    VALUES	(p_strSemester, p_intYear, @UserID);
    
    -- Get latest PK to output to p_intSemesterID
    SELECT intSemesterID INTO p_intSemesterID FROM TSemesters ORDER BY intSemesterID DESC LIMIT 1;
    
    -- Internal intSemesterID variable
    SET @SemesterID = 0;    
    SELECT intSemesterID INTO @SemesterID FROM TSemesters WHERE intUserID = @UserID LIMIT 1;
    
    -- Update to current semester
    UPDATE TUsers
	SET
		intCurrentSemester = @SemesterID
	WHERE
		intUserID = @UserID;
COMMIT;
END //
DELIMITER ;

-- Update a user
DELIMITER //
CREATE PROCEDURE uspUpdateUser (
	IN p_intUserID			INTEGER,
	IN p_strName			VARCHAR(250),
	IN p_strEmail			VARCHAR(250),
    IN p_strPassword		VARCHAR(250),
    IN p_strSecurity		VARCHAR(250),
    IN p_strModified_Reason VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Insert new user
	UPDATE TUsers
    SET
		strName = p_strName,
        strEmail = p_strEmail,
        strPassword = p_strPassword,
        strSecurity	= p_strSecurity,
        strModified_Reason = p_strModified_Reason
	WHERE
		intUserID = p_intUserID;
COMMIT;
END //
DELIMITER ;

-- Add a course
DELIMITER //
CREATE PROCEDURE uspAddCourse (
	IN p_strCourse			VARCHAR(250),
    IN p_strCourseNumber	VARCHAR(250),
    IN p_strInstructor		VARCHAR(250),
    IN p_Monday				BOOLEAN,
    IN p_Tuesday			BOOLEAN,
    IN p_Wednesday			BOOLEAN,
    IN p_Thursday			BOOLEAN,
    IN p_Friday				BOOLEAN,
    IN p_dtmStart			TIME,
    IN p_dtmEnd				TIME,
    IN p_intSemesterID		INTEGER,
    IN p_intUserID			INTEGER,
    OUT p_intCourseID		INTEGER
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Add a course
    INSERT INTO TCourses (strCourse, strCourseNumber, strInstructor, blnMonday, blnTuesday, blnWednesday, blnThursday, blnFriday, dtmStart, dtmEnd, intSemesterID, intUserID)
    VALUES	(p_strCourse, p_strCourseNumber, p_strInstructor, p_Monday, p_Tuesday, p_Wednesday, p_Thursday, p_Friday, p_dtmStart, p_dtmEnd, p_intSemesterID, p_intUserID);
    
    -- Get latest PK
    SELECT intCourseID INTO p_intCourseID FROM TCourses ORDER BY intCourseID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Update a course
DELIMITER //
CREATE PROCEDURE uspUpdateCourse (
	IN p_intCourseID		INTEGER,
	IN p_strCourse			VARCHAR(250),
    IN p_strCourseNumber	VARCHAR(250),
    IN p_strInstructor		VARCHAR(250),
    IN p_Monday				BOOLEAN,
    IN p_Tuesday			BOOLEAN,
    IN p_Wednesday			BOOLEAN,
    IN p_Thursday			BOOLEAN,
    IN p_Friday				BOOLEAN,
    IN p_dtmStart			TIME,
    IN p_dtmEnd				TIME,
    IN p_intSemesterID		INTEGER,
    IN p_intUserID			INTEGER,
    IN p_strModified_Reason	VARCHAR(250)
)
BEGIN 
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	UPDATE TCourses
    SET
		strCourse = p_strCourse,
        strCourseNumber = p_strCourseNumber,
        strInstructor = p_strInstructor,
        blnMonday = p_Monday,
        blnTuesday = p_Tuesday,
        blnWednesday = p_Wednesday,
        blnThursday = p_Thursday,
        blnFriday = p_Friday,
        dtmStart = p_dtmStart,
        dtmEnd = p_dtmEnd,
        intSemesterID = p_intSemesterID,
        strModified_Reason = p_strModified_Reason
	WHERE
		intCourseID = p_intCourseID AND intUserID = p_intUserID;
COMMIT;
END //
DELIMITER ;

-- Add a semester
DELIMITER //
CREATE PROCEDURE uspAddSemester (
	IN p_strSemester	VARCHAR(250),
    IN p_intYear		INTEGER,
    IN p_dtmStartDate	DATETIME,
    IN p_dtmEndDate		DATETIME,
    IN p_intUserID		INTEGER,
    OUT p_intSemesterID INTEGER
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Add a semester
    INSERT INTO TSemesters (strSemester, intYear, dtmStartDate, dtmEndDate, intUserID)
    VALUES	(p_strSemester, p_intYear, p_dtmStartDate, p_dtmEndDate, p_intUserID);
    
    -- Get latest PK
    SELECT intSemesterID INTO p_intSemesterID FROM TSemesters ORDER BY intSemesterID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Update a semester
DELIMITER //
CREATE PROCEDURE uspUpdateSemester (
	IN p_intSemesterID		INTEGER,
    IN p_strSemester		VARCHAR(250),
    IN p_intYear			INTEGER,
    IN p_dtmStartDate		DATETIME,
    IN p_dtmEndDate			DATETIME,
    IN p_intUserID			INTEGER,
    IN p_strModified_Reason	VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	UPDATE TSemesters
    SET
		strSemester = p_strSemester,
        intYear = p_intYear,
        dtmStartDate = p_dtmStartDate,
        dtmEndDate = p_dtmEndDate,
        strModified_Reason = p_strModified_Reason
	WHERE
		intSemesterID = p_intSemesterID AND intUserID = p_intUserID;
COMMIT;
END //
DELIMITER ;

-- Add an assignment
DELIMITER //
CREATE PROCEDURE uspAddAssignment (
	IN p_strAssignment		VARCHAR(250),
    IN p_strDetails			TEXT,
    IN p_dtmDueDate			DATETIME,
    IN p_intStatusID		INTEGER,
    IN p_intCourseID		INTEGER,
    OUT p_intAssignmentID	INTEGER
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	-- Add an assignment
    INSERT INTO TAssignments (strAssignment, strDetails, dtmDueDate, intStatusID, intProgress, intCourseID)
    VALUES	(p_strAssignment, p_strDetails, p_dtmDueDate, p_intStatusID, 0, p_intCourseID);
    
    -- Get latest PK
    SELECT intAssignmentID INTO p_intAssignmentID FROM TAssignments ORDER BY intAssignmentID DESC LIMIT 1;
COMMIT;
END //
DELIMITER ;

-- Update an assignment
DELIMITER //
CREATE PROCEDURE uspUpdateAssignment (
	IN p_intAssignmentID	INTEGER,
    IN p_strAssignment		VARCHAR(250),
    IN p_strDetails			TEXT,
    IN p_dtmDueDate			DATETIME,
    IN p_intStatusID		INTEGER,
    IN p_intProgress		INTEGER,
    IN p_intCourseID		INTEGER,
    IN p_strModified_Reason VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	UPDATE TAssignments
    SET
		strAssignment = p_strAssignment,
        strDetails = p_strDetails,
        dtmDueDate = p_dtmDueDate,
        intStatusID = p_intStatusID,
        intProgress = p_intProgress,
        intCourseID = p_intCourseID,
        strModified_Reason = p_strModified_Reason
	WHERE
		intAssignmentID = p_intAssignmentID;
COMMIT;
END //
DELIMITER ;

-- Check if a user login exists
DELIMITER //
CREATE PROCEDURE uspLoggedIn (
	IN p_strEmail VARCHAR(250),
    IN p_strPassword VARCHAR(250)
)
BEGIN
	SELECT 
		strEmail,
        strPassword,
        intUserID
    FROM
		TUsers
    WHERE
		strEmail = p_strEmail AND strPassword = p_strPassword;
END //
DELIMITER ;

-- Load unfinished assignments
DELIMITER //
CREATE PROCEDURE uspUnfinishedAssignments (
	IN p_intUserID INTEGER,
    IN p_intSemesterID INTEGER
)
BEGIN
	SELECT
        TA.strAssignment,
        TA.intAssignmentID,
        TA.dtmDueDate,
		TC.strCourse,
        TST.strStatus
    FROM
		TCourses as TC JOIN TAssignments as TA
			ON TC.intCourseID = TA.intCourseID
		JOIN TUsers as TU
			ON TU.intUserID = TC.intUserID
		JOIN TSemesters as TS
			ON TS.intSemesterID = TC.intSemesterID
		JOIN TStatuses as TST
			ON TST.intStatusID = TA.intStatusID
    WHERE
		TA.intStatusID = 1 AND TU.intUserID = p_intUserID AND TS.intSemesterID = p_intSemesterID;
END //
DELIMITER ;

-- Load finished assignments
DELIMITER //
CREATE PROCEDURE uspFinishedAssignments (
	IN p_intUserID INTEGER,
    IN p_intSemesterID INTEGER
)
BEGIN
	SELECT
        TA.strAssignment,
        TA.intAssignmentID,
        TA.dtmDueDate,
		TC.strCourse,
        TST.strStatus
    FROM
		TCourses as TC JOIN TAssignments as TA
			ON TC.intCourseID = TA.intCourseID
		JOIN TUsers as TU
			ON TU.intUserID = TC.intUserID
		JOIN TSemesters as TS
			ON TS.intSemesterID = TC.intSemesterID
		JOIN TStatuses as TST
			ON TST.intStatusID = TA.intStatusID
    WHERE
		TA.intStatusID = 2 AND TU.intUserID = p_intUserID AND TS.intSemesterID = p_intSemesterID;
END //
DELIMITER ;

-- Load current courses
DELIMITER //
CREATE PROCEDURE uspCurrentCourses (
	IN p_intUserID INTEGER,
    IN p_intSemesterID INTEGER
)
BEGIN
	SELECT
        TC.strCourseNumber,
        TC.intCourseID,
        TC.strCourse,
        TC.strInstructor,
        TC.dtmStart,
        TC.dtmEnd
    FROM
		TCourses as TC JOIN TUsers as TU
			ON TU.intUserID = TC.intUserID
		JOIN TSemesters as TS
			ON TS.intSemesterID = TC.intSemesterID
    WHERE
		TU.intUserID = p_intUserID AND TS.intSemesterID = p_intSemesterID;
END //
DELIMITER ;

-- Set active semester for a user
DELIMITER //
CREATE PROCEDURE uspActiveSemester (
	IN p_intSemesterID INTEGER,
    IN p_intUserID INTEGER
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	UPDATE TUsers
    SET
		intCurrentSemester = p_intSemesterID
	WHERE
		intUserID = p_intUserID;
COMMIT;
END //
DELIMITER ;

-- Delete a semester
DELIMITER //
CREATE PROCEDURE uspDeleteSemester (
	IN p_intSemesterID 		INTEGER,
    IN p_intUserID 			INTEGER,
    IN p_strModified_Reason VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
    -- NOTE: This uses ON DELETE CASCADE which will delete any rows of containing the deleted ID on any table that is linked to the ID via FK (TCourses).
    -- Delete cascades then apply to TAssignments for any TCourses IDs that were just deleted, allowing for a user to completely wipe any associated data that 
    -- comes with a semester.
    
    -- Delete a semester
	DELETE FROM TSemesters WHERE intSemesterID = p_intSemesterID AND intUserID = p_intUserID;
    
    -- Get max PK
    SET @intSemesterAuditID = 0;
    SELECT MAX(intSemesterAuditID) INTO @intSemesterAuditID FROM Z_TSemesters;
    
    -- Set deletion reason
    UPDATE Z_TSemesters 
    SET	
		strModified_Reason = p_strModified_Reason
	WHERE intSemesterAuditID = @intSemesterAuditID;
    
COMMIT;
END //
DELIMITER ;

-- Reset password
DELIMITER //
CREATE PROCEDURE uspResetPassword (
	IN p_Email 				VARCHAR(250),
    IN p_Password 			VARCHAR(250),
    IN p_strModified_Reason VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
	UPDATE TUsers
    SET
		strPassword = p_Password,
        strModified_Reason = p_strModified_Reason
	WHERE 
		strEmail = p_Email;
COMMIT;
END //
DELIMITER ;

-- Delete a course
DELIMITER //
CREATE PROCEDURE uspDeleteCourse (
	IN p_intCourseID 		INTEGER,
    IN p_intUserID 			INTEGER,
    IN p_strModified_Reason VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;    
    -- Delete course
	DELETE FROM TCourses WHERE intUserID = p_intUserID AND intCourseID = p_intCourseID;
    
    -- Get max PK
    SET @intCourseAuditID = 0;
    SELECT MAX(intCourseAuditID) INTO @intCourseAuditID FROM Z_TCourses;
    
    -- Set deletion reason
    UPDATE Z_TCourses 
    SET	
		strModified_Reason = p_strModified_Reason
	WHERE intCourseAuditID = @intCourseAuditID;
COMMIT;
END //
DELIMITER ;

-- Delete an assignment
DELIMITER //
CREATE PROCEDURE uspDeleteAssignment (
	IN p_intAssignmentID 	INTEGER,
    IN p_strModified_Reason VARCHAR(250)
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  -- Rollback any error in the transaction
        RESIGNAL;  -- Return error information
    END;
START TRANSACTION;
    -- Delete assignment
	DELETE FROM TAssignments WHERE intAssignmentID = p_intAssignmentID;
    
    -- Get max PK
    SET @intAssignmentAuditID = 0;
    SELECT MAX(intAssignmentAuditID) INTO @intAssignmentAuditID FROM Z_TAssignments;
    
    -- Set deletion reason
    UPDATE Z_TAssignments 
    SET	
		strModified_Reason = p_strModified_Reason
	WHERE intAssignmentAuditID = @intAssignmentAuditID;
COMMIT;
END //
DELIMITER ;

-- Select all assignments that have due dates between now and the next 30 days
DELIMITER //
CREATE PROCEDURE uspMonthlyAssignments (
    IN p_intUserID INTEGER,
    IN p_intSemesterID INTEGER
)
BEGIN
	SELECT
		TA.intAssignmentID,
        TA.strAssignment,
        TA.dtmDueDate,
        TC.intCourseID,
        TC.strCourse,
        TS.strStatus
    FROM
		TCourses as TC JOIN TAssignments as TA
			ON TC.intCourseID = TA.intCourseID
		JOIN TStatuses as TS
			ON TS.intStatusID = TA.intStatusID
		JOIN TUsers as TU
			ON TU.intUserID = TC.intUserID
		JOIN TSemesters as TSM
			ON TSM.intSemesterID = TC.intSemesterID
	WHERE
		TU.intUserID = p_intUserID 
        AND TS.intStatusID = 1 
        AND TSM.intSemesterID = p_intSemesterID
        AND TA.dtmDueDate > NOW() AND TA.dtmDueDate < DATE_ADD(NOW(), INTERVAL 30 DAY);
END //
DELIMITER ;