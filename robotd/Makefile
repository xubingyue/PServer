BINARY=bin/robotd
TARGET= $(BINARY)
LINK=g++
HOME=../
CINC=-I/usr/local/tsf4g/include -I/usr/local/tlibc/include/ -Itdr
LDPATH=-L/usr/local/tsf4g/lib -L/usr/local/tlibc/lib
DEPLIBS=-ltapp -ltlibc
DEPOFILE=

TYPES_TDR_FILE=$(wildcard tdr/*.tdr)
READER_TDR_FILE=$(wildcard tdr/*.tdr)

CPPFILE=$(wildcard source/*.cpp)
DFILE=$(wildcard source/*.d)
DFILE+=$(wildcard tdr/*.d)

include $(HOME)/build.mk

dep:
	@mkdir -p bin

install:
	mkdir -p $(PREFIX)
	cp -rf bin $(PREFIX)

