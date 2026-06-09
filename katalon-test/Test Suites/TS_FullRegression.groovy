import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import com.kms.katalon.core.testcase.TestCaseFactory
import com.kms.katalon.core.testdata.TestDataFactory
import com.kms.katalon.core.testobject.ObjectRepository
import com.kms.katalon.core.configuration.RunConfiguration
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable

/**
 * Full Regression Test
 * 
 * Includes ALL test cases:
 * - Test Cases/Frontend/*
 * - Test Cases/Backend/*
 * - Test Cases/Cart/*
 */

RunConfiguration.setExecutionProfile('default')
