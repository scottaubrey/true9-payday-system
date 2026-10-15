type ErrorResponse = {
  success: false;
  error: string;
};
type SuccessResponse<ViewType> = { success: true; data: ViewType };
type Response<ViewType> = SuccessResponse<ViewType> | ErrorResponse;

type PayDayView = {
  payDate: Date;
  paymentDate: Date;
};
type PayDayViewData = { payDate: string; paymentDate: string };

const isValidPayDayView = (data: unknown): data is PayDayViewData => {
  if (typeof data !== "object") {
    return false;
  }

  if (data === null) {
    return false;
  }

  if (!("payDate" in data) || !("paymentDate" in data)) {
    return false;
  }

  if (
    typeof data.payDate !== "string" ||
    typeof data.paymentDate !== "string"
  ) {
    return false;
  }

  return true;
};

export const ApiClient = {
  payday: async (
    _year: string,
    _month: string,
  ): Promise<Response<PayDayView>> => {
    const response = await fetch("/api/payday");

    let data: PayDayViewData;
    try {
      const rawData = await response.json();

      if (response.status !== 200) {
        return {
          success: false,
          error: "message" in rawData ? rawData.message : response.statusText,
        };
      }

      if (!isValidPayDayView(rawData)) {
        return {
          success: false,
          error: "Validation error",
        };
      }

      data = rawData;
    } catch (_error: unknown) {
      return {
        success: false,
        error: "Validation error",
      };
    }

    if (!isValidPayDayView(data)) {
      console.log("Validation");
      return {
        success: false,
        error: "Validation error",
      };
    }

    return {
      success: true,
      data: {
        payDate: new Date(data.payDate),
        paymentDate: new Date(data.paymentDate),
      },
    };
  },
};
