import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.testobject.RequestObject
import com.kms.katalon.core.testobject.ResponseObject
import com.kms.katalon.core.testobject.ConditionType
import com.kms.katalon.core.testobject.TestObjectProperty
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import internal.GlobalVariable

def request = new RequestObject("GET_Provinces")
request.setRestUrl(GlobalVariable.APP_URL + "/provinces")
request.setHttpHeaderProperties([
	new TestObjectProperty("Content-Type", ConditionType.EQUALS, "application/json")
])

def response = WS.sendRequest(request)

WS.verifyResponseStatusCode(response, 200)
WS.verifyElementPropertyValue(response, "success", true)
WS.comment("API RajaOngkir - Provinces: OK")
