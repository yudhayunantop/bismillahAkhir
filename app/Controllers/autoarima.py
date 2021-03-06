import numpy as np # linear algebra
import pandas as pd # data processing, CSV file I/O (e.g. pd.read_csv)
#%matplotlib inline
import matplotlib.pyplot as plt
from statsmodels.tsa.arima_model import ARIMA
import pmdarima as pm
import numpy as np

def mape(actual, pred): 
    actual, pred = np.array(actual), np.array(pred)
    return np.mean((np.abs(actual - pred) / actual))*100 

df = pd.read_csv('C:/xampp/htdocs/bismillahAkhir/public/data.csv', names=['value'])
# pd.set_option('display.max_rows', df.shape[0]+1)

# Seasonal True dan m=12 karena dataset merupakan data bulanan dari 12 bulan
model = pm.auto_arima(df.value, start_p=0, start_q=0,
                      test='adf',           # use adftest to find optimal 'd'
                      max_p=5, max_q=3,     # maximum p and q
                      m=12,                 # frequency of series (Data ada 1 tahun 12 bulan)
                      seasonal=True,        # Data bulanan,
                      D=1,                  # Data per satubulan
                      trace=True,
                      error_action='ignore',  
                      suppress_warnings=True, 
                      stepwise=True
                      )

#divide into train and validation set
train = df[:int(len(df)-10)]
valid = df[int(len(df)-10):]

# Forecast for accuracy
forecast = model.predict(n_periods=len(valid))
forecast = pd.DataFrame(forecast,index = valid.index,columns=['Prediction'])

forecast = round(forecast)

#calculate mape
mape = mape(valid, forecast)

# MSE Library
# mse = mean_squared_error(valid,forecast)

# MSE Manual
difference_array = np.subtract(valid, forecast)
squared_array = np.square(difference_array)
mse = squared_array.mean()

print('MAPE : ', mape)
print('MSE : ', mse)

############################################################################################

# Forecast
n_periods = 12
fc, confint = model.predict(n_periods=n_periods, return_conf_int=True)
index_of_fc = np.arange(len(df.value), len(df.value)+n_periods)

# make series for plotting purpose
fc_series = pd.Series(fc, index=index_of_fc)
lower_series = pd.Series(confint[:, 0], index=index_of_fc)
upper_series = pd.Series(confint[:, 1], index=index_of_fc)

print(fc_series)
# Plot Data
fig = plt.figure()
ax = fig.add_subplot()
fig.subplots_adjust(top=0.85)

ax.set_xlabel('Bulan ke-')
ax.set_ylabel('Nominal')

plt.plot(df.value)

plt.plot(fc_series, color='darkgreen')
plt.fill_between(lower_series.index, 
                 lower_series, 
                 upper_series, 
                 color='k', alpha=.15)

plt.title("Hasil Peramalan (Error: %.3f persen)" % mape)
# Ubah ke format angka asli
# ax.ticklabel_format(useOffset=False, style='plain')
plt.show()