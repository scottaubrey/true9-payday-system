export const PaydayResultTestIds = {
  payDate: "PaydayResult.payDate",
  paymentDate: "PaydayResult.paymentDate",
};

const WEEKDAYS = [
  "Sunday",
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
];

const formatDate = (date: Date) => {
  return `${WEEKDAYS[date.getUTCDay()]}, ${date.getUTCDate()}/${String(date.getUTCMonth() + 1)}/${date.getUTCFullYear()}`;
};

export const PaydayResult = ({
  payDate,
  paymentDate,
}: {
  payDate: Date;
  paymentDate: Date;
}) => (
  <>
    <dl>
      <dt>Pay Date</dt>
      <dd data-testid={PaydayResultTestIds.payDate}>{formatDate(payDate)}</dd>
      <dt>Payment Date</dt>
      <dd data-testid={PaydayResultTestIds.paymentDate}>
        {formatDate(paymentDate)}
      </dd>
    </dl>
  </>
);
