import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import com.kms.katalon.core.testcase.TestCaseFactory
import com.kms.katalon.core.testdata.TestDataFactory
import com.kms.katalon.core.testobject.ObjectRepository
import com.kms.katalon.core.configuration.RunConfiguration
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable

/**
 * Smoke Test - Frontend
 * 
 * Test Cases:
 * - Test Cases/Frontend/TC_HomePage
 * - Test Cases/Frontend/TC_ProductListing
 * - Test Cases/Frontend/TC_ProductDetail
 * - Test Cases/Frontend/TC_ProductByCategory
 */

RunConfiguration.setExecutionProfile('default')
