import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import com.kms.katalon.core.model.FailureHandling
import internal.GlobalVariable
import keywords.common_keywords

WebUI.openBrowser('')
WebUI.maximizeWindow()

common_keywords keywords = new common_keywords()
keywords.loginAsAdmin()

WebUI.navigateToUrl(GlobalVariable.APP_URL + "/backend/customer")
WebUI.verifyElementPresent(findTestObject('Page_Customer/heading_customer'), 5, FailureHandling.CONTINUE_ON_FAILURE)

int totalCustomer = WebUI.findWebElements(findTestObject('Page_Customer/row_customer'), 5).size()
WebUI.comment("Total customer: " + totalCustomer)

WebUI.takeScreenshot('Screenshots/TC_ManageCustomers.png')
WebUI.closeBrowser()
