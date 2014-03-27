NAME=centerd
EXECUTABLE=1
DEPTARGET=common
USE_CXX=1

SHARED_DIR=../../PShared
DEPLOCALINCLUDE=/usr/local/TLibC/include /usr/local/include $(SHARED_DIR)/centerp/include
DEPLOCALLD=/usr/local/TLibC/lib /usr/local/lib/ $(SHARED_DIR)/centerp/lib
DEPLOCALLIBS=tlibc thrift centerp

include ../build.mk
