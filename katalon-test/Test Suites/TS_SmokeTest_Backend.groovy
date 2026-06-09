import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import com.kms.katalon.core.testcase.TestCaseFactory
import com.kms.katalon.core.testdata.TestDataFactory
import com.kms.katalon.core.testobject.ObjectRepository
import com.kms.katalon.core.configuration.RunConfiguration
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable

/**
 * Smoke Test - Backend Admin
 * 
 * Test Cases:
 * - Test Cases/Backend/TC_AdminLogin
 * - Test Cases/Backend/TC_AdminDashboard
 * - Test Cases/Backend/TC_ManageCategories
 * - Test Cases/Backend/TC_ManageProducts
 * - Test Cases/Backend/TC_ManageOrders
 * - Test Cases/Backend/TC_ManageCustomers
 */

RunConfiguration.setExecutionProfile('default')
